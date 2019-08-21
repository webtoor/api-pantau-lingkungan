<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\User_role;

class AuthController extends Controller
{
    public function register(Request $request){
        $this->validate($request, [
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'email'    => 'required|email|unique:users',
            'phonenumber' => 'required|numeric|min:10',
            'password' => 'required|string|min:5|confirmed',
            'alamat' => 'required'
        ]);  

       $results_user = User::create([
            'firstname' => $request['firstname'],
            'lastname' => $request['lastname'],
            'email' => $request['email'],
            'phonenumber' => $request['phonenumber'],
            'gender' => $request['gender'],
            'dob' => $request['dob'],
            'alamat' => $request['alamat'],
            'password' => $request['password']

        ]);

      $results_role = User_role::create([
            'user_id' => $results_user->id,
            'role_id' => '1'
      ]);

      if($resultUser && $resultRole){
        return response()->json([
            'status' => 'berhasil',
            'message' => 'Berhasil membuat akun!'
            ], 201);
        }else{
            return response()->json([
            'status' => 'gagal',
            'message' => 'Gagal membuat akun!'
            ], 400);
        }

    }
}
