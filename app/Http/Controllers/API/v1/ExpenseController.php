<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\DataUserModel;
use App\Models\DataExpenseModel;

use App\Http\Traits\ExceptionTrait;
use App\Helpers\Utility;

use Validator;

class ExpenseController extends Controller
{
    use ExceptionTrait;//if exception it will email developer set in config and return 500

    const API_CONTROLLER = 'ExpenseController';

    protected $user;

    public function __construct()
    {
        //wrote small middleware if user is null middleware - CheckAuthApi
        $this->user = auth('api')->user();
    }

    public function index(Request $request)
    {
        try {
            $dataExpenseModel = DataExpenseModel::fetchExpenses($this->user, $request);//made static function. Should maybe use repository classes to build up the sql etc..

            if(count($dataExpenseModel) > 0)
                return response()->json($dataExpenseModel, 200);
            else
                return response()->json(null, 204);
        } catch (\Exception $e) {
            return $this->sendApiException(self::API_CONTROLLER, 'index', $e->getMessage(), $this->user->id); //Mail Developer if exception which could be coding issue, remember turn off debug mode when going live. It has return 500 in the trait
        }
    }

    public function store(Request $request)
    {
        Utility::stripXSS($request);//clean any xss or html etc.

        $validator = Validator::make($request->all(), [
            'amount'          => 'required|integer|min:100',//this must be in pence or cents (Better to work in this if you want to do totals for amounts later). Not sure what lowest amount is that is required but put min of £1
            'description'     => 'required|string|min:3',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 400);
        }

        try {
            $data               = $request->all();
            $data['user_id']    = $this->user->id;//this way client won't need to send user_id as we have it via the Auth

            $dataExpenseModel   =  DataExpenseModel::create($data);

            return response()->json($dataExpenseModel->format(), 201);//format before we output
        } catch (\Exception $e) {
            return $this->sendApiException(self::API_CONTROLLER, 'store', $e->getMessage(), $this->user->id); //Mail Developer if exception which could be coding issue, remember turn off debug mode when going live. It has return 500 in the trait
        }
    }

    public function show($id)
    {
        return DataExpenseModel::findorfail($this->user, $id)->format(); //format before we send data. Fail will throw 404 , doubt we need mails for every 404. :D created static class
    }

    public function update(Request $request, $id)
    {
        Utility::stripXSS($request);//clean any xss or html etc.

        $validator = Validator::make($request->all(), [
            'amount'          => 'required|integer|min:100',//this must be in pence or cents (Better to work in this if you want to do totals for amounts later). Not sure what lowest amount is that is required but put min of £1
            'description'     => 'required|string|min:3',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 400);
        }

        $dataExpenseModel = DataExpenseModel::findorfail($this->user, $id);//created static class
        try {
            $dataExpenseModel->update($request->all());//don't need user_id if all expenses below to the user using api.(if api uses global user for all api calls then will need user_id)

            return response()->json($dataExpenseModel->format(), 200);
        } catch (\Exception $e) {
            return $this->sendApiException(self::API_CONTROLLER, 'update', $e->getMessage(), $this->user->id); //Mail Developer if exception which could be coding issue, remember turn off debug mode when going live. It has return 500 in the trait
        }
    }

    public function destroy($id)
    {
        $dataExpenseModel = DataExpenseModel::findorfail($this->user, $id); //Fail will throw 404 , doubt we need mails for every 404. :D
        try {
            $dataExpenseModel->delete();

            return response()->json(null, 204);//not sure if you want 200 to give sucess message or 204 for no content
        } catch (\Exception $e) {
            return $this->sendApiException(self::API_CONTROLLER, 'destroy', $e->getMessage(), $this->user->id); //Mail Developer if exception which could be coding issue, remember turn off debug mode when going live. It has return 500 in the trait
        }
    }
}
