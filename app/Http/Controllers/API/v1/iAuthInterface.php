<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

interface iAuthInterface
{
    /**
     * @OA\Schema(
     *   schema="registerItems",
     *   @OA\Property(
     *    property="name",
     *      type="string"
     *   ),
     *   @OA\Property(
     *      property="email",
     *      type="string"
     *   ),
     *   @OA\Property(
     *      property="created_at",
     *      type="string"
     *   ),
     *   @OA\Property(
     *      property="updated_at",
     *      type="string"
     *   ),
     * )
     */

     /**
      * @OA\Schema(
      *   schema="registerPost",
      *   @OA\Property(
      *     property="name",
      *     type="string"
      *   ),
      *   @OA\Property(
      *     property="email",
      *     type="string"
      *   ),
      *   @OA\Property(
      *     property="password",
      *     type="string"
      *   ),
      *   @OA\Property(
      *     property="key",
      *     type="string"
      *   ),
      * )
      */

      /**
       * @OA\Schema(
       *   schema="loginPost",
       *   @OA\Property(
       *     property="email",
       *     type="string"
       *   ),
       *   @OA\Property(
       *     property="password",
       *     type="string"
       *   ),
       *   @OA\Property(
       *     property="key",
       *     type="string"
       *   ),
       * )
       */

       /**
        * @OA\Schema(
        *   schema="loginItems",
        *   @OA\Property(
        *    property="access_token",
        *      type="string"
        *   ),
        *   @OA\Property(
        *      property="token_type",
        *      type="string"
        *   ),
        *   @OA\Property(
        *      property="expires_at",
        *      type="string"
        *   ),
        * )
        */

      /**
       * @OA\Post(
       *      path="/api/1.0/register",
       *      summary="Register a user to be able to user our api",
       *      description="Returns the stored expenses",
       *      tags={"register.register"},
       *      @OA\RequestBody(
       *          required=true,
       *          @OA\JsonContent(ref="#/components/schemas/registerPost")
       *      ),
       *      @OA\Response(
       *        response="201",
       *        description="Successfully created",
       *        @OA\JsonContent(
       *             type="object",
       *             @OA\Property(
       *                property="example",
       *                example={
       *                        "name": "Name",
       *                        "email": "email@email.com",
       *                        "created_at": "2020-08-23 10:09:37",
       *                        "updated_at": "2020-08-23 10:09:37"
       *                },
       *                  @OA\Items(ref="#/components/schemas/registerItems"),
       *             ),
       *        ),
       *     ),
       *      @OA\Response(
       *          response=400,
       *          description="Bad Request"
       *      ),
       *      @OA\Response(
       *          response=403,
       *          description="Forbidden"
       *      )
       * )
       */
    public function register(Request $request);


    /**
     * @OA\Post(
     *      path="/api/1.0/login",
     *      summary="Logs in a user to be able to user our api",
     *      description="Returns the Bearer token",
     *      tags={"register.login"},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/loginPost")
     *      ),
     *      @OA\Response(
     *        response="200",
     *        description="Successfully logged in",
     *        @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                property="example",
     *                example={
     *                        "access_token": "long generated key",
     *                        "token_type": "Bearer",
     *                        "expires_at": "2020-08-30 10:22:58"
     *                    },
     *                  @OA\Items(ref="#/components/schemas/loginItems"),
     *             ),
     *        ),
     *     ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated"
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function login(Request $request);

    /**
     * @OA\get(
     *      path="/api/1.0/logout",
     *      summary="Logs out user from system eg revoking it's key",
     *      description="Returns 200",
     *      tags={"register.logout"},
     *      @OA\Response(
     *        response="200",
     *        description="Successfully logged out",
     *        @OA\JsonContent(),
     *        ),
     *     ),
     *      @OA\Response(
     *          response=202,
     *          description="HTTP ACCEPTED"
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function logout();
}
