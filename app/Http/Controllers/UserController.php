<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Laporan;
use App\Location;

class UserController extends Controller
{
    public function createLaporan(Request $request){
         // Validate
         $this->validate($request, [
            'user_id' => 'required',
            'judul' => 'required|string',
            'kategori' => 'required',
            'deskripsiLaporan' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'accuracy' => 'required'
           ]);

          $result_laporan = Laporan::create([
            'user_id' => $request->json('user_id'),
            'judul' => $request->json('judul'),
            'kategori_id' => $request->json('kategori'),
            'deskripsiLaporan' => $request->json('deskripsiLaporan'),
            'namaPerusahaan' => $request->json('namaPerusahaan'),
            'desaKelurahan' => $request->json('desaKelurahan'),
            'kecamatan' => $request->json('kecamatan'),
            'kotaKabupaten' => $request->json('kotaKabupaten'),
            'provinsi' => $request->json('provinsi'),
           ]);

           $result_location = Location::create([
               'laporan_id' => $result_laporan->id,
               'latitude' => $request->json('latitude'),
               'longitude' => $request->json('longitude'),
               'altitude' => $request->json('altitude'),
               'accuracy' => $request->json('accuracy'),
           ]);

           if($result_laporan && $result_location){
            return response()->json([
                'status' => '1',
                'message' => 'Sukses mengirim laporan!'
                ]);
            }else{
                return response()->json([
                'status' => '0',
                'message' => 'Sukses mengirim laporan!'
                ]);
            }
    }
}
