<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {  

        $data=json_decode($request->getContent());
        $email = $data->email;
        $password = $data->password;
        
        if (empty($email) or (empty($password))) {
            return response()->json(['status' => 'error', 'msg' => 'data is required']);
        }

        $check_user = User::where('email', $email)->first();
        if (@count($check_user) > 0) {
            if (Hash::check($password, $check_user['password'])) {
                $response['token'] = $check_user->createToken('users')->accessToken;
                $response['status'] = 200;
                $response['data'] = $check_user;
                return response()->json($response, 200);
            } else {
                $response['status'] = 401;

                return response()->json($response, 401);
            }
        }else{
            return response()->json(['status' => 'error', 'msg' => "Credentiadls doesn't match"]);
        }
    }


    /**
     * API Register
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $data=json_decode($request->getContent());
        
        $email = $data->email;
        $password = $data->password;
        $name = $data->name;


        $rules = [
            'name' => 'required',
            'email'    => 'unique:users|required',
            'password' => 'required',
        ];

        $input     = $data->only('name', 'email','password');
        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'msg' => $validator->messages()]);
        }
        $user = User::create(['name' => $name, 'email' => $email, 'password' => Hash::make($password)]);

        $response['status'] = 200;
        $response['data'] = $user;
        return response()->json($response, 200);
    }


    public function authCheck(Request $request){     
            echo "priya"; die;
    }
}

