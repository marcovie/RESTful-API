<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
//Auth section of the API
Route::post('1.0/register', 'API\v1\AuthController@register')->name('register');
Route::post('1.0/login', 'API\v1\AuthController@login')->name('login');

//Can change throttle limit if required. Added namespace so only have to put controller names.
//Added v1 for verion of api incase we want to deprecate v1 to v2 in the future etc
Route::middleware('checkauthapi', 'throttle:60,1')->prefix('1.0')->namespace('API\v1')->group(function () {//added a middleware that check auth
    //Auth Logout
    Route::get('logout', 'AuthController@logout')->name('logout');

    //Fetch Data from DataExpenseModel
    Route::apiResource('expense', 'ExpenseController')->only(['index', 'store', 'show', 'update', 'destroy']);//The only shouldn't be needed
});

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
