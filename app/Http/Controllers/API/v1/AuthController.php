<?php

namespace App\Http\Controllers\API\v1;

use Symfony\Component\HttpFoundation\Response;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\ExceptionTrait;
use App\Helpers\Utility;

use App\Models\DataUserModel;

use Carbon\Carbon;
use Validator;

class AuthController extends Controller
{
    use ExceptionTrait;//if exception it will email developer set in config and return 500

    const API_CONTROLLER = 'AuthController';

    public function register(Request $request)
    {
        Utility::stripXSS($request);//clean any xss or html etc.

        if($request->key != 'password')//Need to make a key that unique maybe with dates for every hour so that not anyone can register for now I made default key password incase you want to test register
            abort(Response::HTTP_FORBIDDEN, '403 Forbidden');

        $validator = Validator::make($request->all(), DataUserModel::RULE_REGISTER);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], Response::HTTP_BAD_REQUEST);
        }

        try {
            $dataUserModel = new DataUserModel([
                'name'      => $request->name,
                'email'     => $request->email,
                'password'  => Hash::make($request->password),
            ]);

          if($dataUserModel->save())
            return response()->json($dataUserModel->format(), Response::HTTP_CREATED);//added format if we want to specific type format for certain things

        } catch (\Exception $e) {
            return $this->sendApiException(self::API_CONTROLLER, 'register', $e->getMessage(), 0); //Mail Developer if exception which could be coding issue, remember turn off debug mode when going live. It has return 500 in the trait
        }
    }

    public function login(Request $request)
    {
        //Don't think key needed for login but might be worth it for extra security
        if($request->key != 'password')//Need to make a key that unique maybe with dates for every hour so that not anyone can register for now I made default key password incase you want to test register
            abort(Response::HTTP_FORBIDDEN, '403 Forbidden');

        $validator = Validator::make($request->all(), DataUserModel::RULE_LOGIN);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], Response::HTTP_BAD_REQUEST);
        }

        try {
            $credentials = $request->only(['email', 'password']);

            if(!Auth::attempt($credentials))
                return response()->json(['message' => 'Unauthenticated.'], Response::HTTP_UNAUTHORIZED);

            $user               = $request->user();

            $tokenResult        = $user->createToken('Personal Access Token');
            $token              = $tokenResult->token;
            $token->expires_at  = Carbon::now()->addWeeks(1);
            $token->save();

            return $this->respondWithToken($tokenResult);
        } catch (\Exception $e) {
            return $this->sendApiException(self::API_CONTROLLER, 'login', $e->getMessage(), 0);
        }
    }

    public function logout(Request $request)
    {
        try {
            if(auth('api')->user()->token()->revoke())
                return response()->json(['message' => 'Successfully logged out'], Response::HTTP_OK);

            return response()->json(null, Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\Exception $e) {
            return response()->json(null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    protected function respondWithToken($token)
    {
      return response()->json([
        'access_token' => $token->accessToken,
        'token_type' => 'Bearer',
        'expires_at' => Carbon::parse($token->token->expires_at)->toDateTimeString()//Not sure if you want to add expire date or not
      ]);
    }
}
