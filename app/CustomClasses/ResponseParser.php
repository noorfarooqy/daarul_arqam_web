<?php
namespace App\CustomClasses;

use Illuminate\Support\Facades\Response;

class ResponseParser
{
    public static function Parse($error_status, $error_message=null, $data=[]){
        return Response::json([
            "errorMessage" => $error_message,
            "isSuccess" => $error_status,
            "data" => $data
        ]);
    }
}
