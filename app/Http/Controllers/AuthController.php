<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $request){
        $this->validate($request, [
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'email'    => 'required|email|unique:users',
            'phonenumber' => 'required|numeric|min:10',
            'password' => 'required|string|min:5|confirmed',
            'desa_kelurahan' => 'required'
        ]);  

    }
}
