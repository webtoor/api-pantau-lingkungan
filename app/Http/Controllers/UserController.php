<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function postLaporan(Request $request){
       return response()->json($request);
    }
}
