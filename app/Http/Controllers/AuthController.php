<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\User_role;

class AuthController extends Controller
{
    public function register(Request $request){
        $this->validate($request, [
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'email'    => 'required|email|unique:users',
            'phone_number' => 'required|numeric|min:10',
            'password' => 'required|string|min:5|confirmed',
            'alamat' => 'required'
        ]);  

       $results_user = User::create([
            'firstname' => $request->json('firstname'),
            'lastname' => $request->json('lastname'),
            'email' => $request->json('email'),
            'phone_number' => $request->json('phone_number'),
            'gender' => $request->json('gender'),
            'dob' => $request->json('dob'),
            'alamat' => $request->json('alamat'),
            'password' => Hash::make($request->json('password')),

        ]);

      $results_role = User_role::create([
            'user_id' => $results_user->id,
            'role_id' => '1'
      ]);

      if($results_user && $results_role){
        return response()->json([
            'status' => 'berhasil',
            'message' => 'Berhasil membuat akun!'
            ]);
        }else{
            return response()->json([
            'status' => 'gagal',
            'message' => 'Gagal membuat akun!'
            ]);
        }

    }
}
