<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function login(Request $request) {
        $rules = [
            'email'=> 'required|email',
            'password'=>'required'
        ];
        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }

        if(Auth::attempt(['email' => request('email'), 'password'=> request('password')])) {
            $user = Auth::user();
            // return the role of the user
            $roles = $user->getRoleNames();
            $success['email'] = $user->email;
            $success['role'] = $roles;
            $success['token'] = $user->createToken('timecardApi')->accessToken;
            return response()->json(['success'=> $success], 200);
        } else {
            return response()->json(['error'=>'Unauthorized'], 401);
        }

    }
}
