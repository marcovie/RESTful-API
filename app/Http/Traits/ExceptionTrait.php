<?php

namespace App\Http\Traits;

use Illuminate\Http\Request;

use Mail;

trait ExceptionTrait
{
  //  This could be more generic that could be used accross the entire system
  //  Emails is just hardcoded from a constant file under config folder
  public function sendApiException($apiController, $function, $exception, $user_id)
  {
    $data = array('apiController'=> $apiController, 'function' => $function, 'exception'=> $exception, 'user_id' => $user_id);
    Mail::send(['html'=>'emails/emailExceptionErrorToDeveloper'], $data, function($message) {
         $message->to(\Config::get('constants.emails.DEVELOPER_EMAIL'), 'Api Exception Error')->subject('Api Exception Error for the API');
         $message->from(\Config::get('constants.emails.NO_REPLY_EMAIL'),'No-Reply');
    });
    return response()->json(null, 500);
  }
}
