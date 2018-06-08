<?php

namespace App\Http\Controllers;

use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\User;
use Libraries\PHPqrcode\VikCode\VikCode as VikCode;
use QRbitstream;
use QRcode;
use QRencode;
use QRimage;
use QRinput;
use QRinputItem;
use QRmask;
use QRrawcode;
use QRrs;
use QRrsItem;
use QRrsblock;
class UsersController extends Controller {

    function __construct() {

//        $this->middleware('auth:api');
    }

    /**
          * Display a listing of the resource.
          *
          * @return \Illuminate\Http\Response
          */
    public function authenticate(Request $request) {


        $validator = Validator::make($request->all(), [
                    'email' => 'required|email',
                    'password' => 'required'
        ]);
        if (!$validator->fails()) {

            $user = User::where('email', $request->input('email'))->first();

            if ($user && (md5($request->input('password')) == $user->password)) {

                $apikey = base64_encode(str_random(40));
                $r=User::where('email', $request->input('email'))->update(['api_token' => "$apikey"]);
                return response()->json(['status' => 'success','r'=>$r, 'user' => $user->toArray(), 'api_token' => $apikey]);
            } else {
                return response()->json(['status' => 'notValid', 'errors' => array('E-mail or Password not match')], 200);
            }
        } else {

            return response()->json(['status' => 'notValid', 'errors' => $validator->errors()->all()], 200);
        }
    }

    public function register(Request $request) {
        $_POST = $request->json()->all();
        $validator = Validator::make($request->all(), [
                    'name' => 'required',
                    'email' => 'required|email|unique:users',
                    'password' => 'required',
        ]);
        if (!$validator->fails()) {
            User::create(array('email' => $_POST['email'],
                'password' => $_POST['password'],
                'name' => $_POST['name']
            ));
            $user = User::where('email', $_POST['email'])->first();
            $apikey = base64_encode(str_random(40));
            User::where('email', $request->input('email'))->update(['api_token' => "$apikey"]);
            return response()->json(['status' => 'success', 'user' => $user->toArray(), 'api_token' => $apikey]);
        } else {
            return response()->json(['status' => 'notValid', 'errors' => $validator->errors()->all()], 200);
        }
    }
    public function qrcode(Request $request){
        // we building raw data 
        $codeContents = 'https://github.com/VikashAmbani/'; 
        /** using file path  */ 
        //  $qr=QRcode::png($codeContents,'vikQrcode.png',QR_ECLEVEL_L, 3);
         /** direct qr code */
         QRcode::png($codeContents);
    }

}
