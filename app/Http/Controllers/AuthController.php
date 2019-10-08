<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\User;
use App\User_role;

class AuthController extends Controller
{
    public function register(Request $request){
        $this->validate($request, [
            'namaDepan' => 'required|string',
            'namaBelakang' => 'required|string',
            'email'    => 'required|email|unique:users',
            'jenisKelamin' => 'required',
            'noHp' => 'required|numeric|min:10|unique:users',
            'alamat' => 'required',
            'password' => 'required|string|min:5|confirmed',
        ]);  
       $results_user = User::create([
            'namaDepan' => $request->json('namaDepan'),
            'namaBelakang' => $request->json('namaBelakang'),
            'email' => $request->json('email'),
            'noHp' => $request->json('noHp'),
            'jenisKelamin' => $request->json('jenisKelamin'),
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
                    'client_id' => '2',
                    'client_secret'=> 'EzeCq9qsmUKhIcMbUmGBaDgWgRL08rX1NH81GITd',
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

    public function logout(){
        $accessToken = Auth::user()->token();
             DB::table('oauth_refresh_tokens')
                 ->where('access_token_id', $accessToken->id)
                 ->update(['revoked' => true]);
             DB::table('oauth_refresh_tokens')
                 ->where('access_token_id', $accessToken->id)
                 ->delete();
                 $accessToken->revoke();
                 $accessToken->delete();
         return response()->json([
             'success' => '1',
             'message' => 'Berhasil logout']);
     }
}
