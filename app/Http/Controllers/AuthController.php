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
    public function login(Request $request){

        $this->validate($request, [
            'email' => 'required:email',
            'password' => 'required'
        ]);
        global $app; 

        $email = $request->json('email');
        $password = $request->json('password');
        $user_role = '1';

        $resultUser = User::where('email', $email)->first();
            if(!$resultUser){
                // Email not exist 
                return response()->json([
                    "error" => "invalid_credentials",
                    "message" => "The user credentials were incorrect"
                   ]);
            }
            if(Hash::check($password, $resultUser->password) ) {

                // Email && Password exist + Check user_role
                if(($user_role) == ($resultUser->role->role_id)){

                $params = [
                    'grant_type'=>'password',
                    'client_id' => '1',
                    'client_secret'=> 'goFARpNfWmFPutzH4ZQXiw0e5Lj2iyd69yF83W7A',
                    'username'  => $email,
                    'password'  => $password,
                    'scope'     => '*'
                ];
                
                $proxy = Request::create('/oauth/token','post', $params);
                $response = $app->dispatch($proxy);
                $json = (array) json_decode($response->getContent());
                $json['id'] = $resultUser->id;
                $json['email'] = $resultUser->email;
                return $response->setContent(json_encode($json)); 

                }else{
                    // != User role
                    return response()->json([
                     "error" => "invalid_credentials",
                     "message" => "The user credentials were incorrect"
                    ]);
                }
            }else{
                //Email exist, Password not exist
                return response()->json([
                    "error" => "invalid_credentials",
                    "message" => "The user credentials were incorrect"
                   ]);
            } 

    }
}
