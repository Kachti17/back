<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;

class MailController extends Controller
{
    public function send(){

        try{
            Mail::to('oussemakachti@gmail.com')->send(new MailNotify());
            return response()->json(['Great check your mail box']);
        }catch(Exception $th)
        {
            return response()->json(['Sorry, something went wrong']);
        }
    }
}