<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Laporan;

class UserController extends Controller
{
    public function createLaporan(Request $request){
         // Validate
         $this->validate($request, [
            'user_id' => 'required|string',
            'judul' => 'required|string',
            'kategori' => 'required',
            'deskripsiLaporan' => 'required'
           ]);

           $result_laporan = Laporan::create([
            'user_id' => $request->json('user_id'),
            'judul' => $request->json('judul'),
            'kategori' => $request->json('kategori'),
            'deskripsiLaporan' => $request->json('deskripsiLaporan'),
            'namaPerusahaan' => $request->json('namaPerusahaan'),
            'desaKelurahan' => $request->json('desaKelurahan'),
            'kecamatan' => $request->json('kecamatan'),
            'kotaKabupaten' => $request->json('kotaKabupaten'),
            'provinsi' => $request->json('provinsi'),
           ]);

           if($result_laporan){
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
