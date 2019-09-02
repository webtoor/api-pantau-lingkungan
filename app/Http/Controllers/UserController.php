<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use App\Laporan;
use App\Location;
use App\Photo;


class UserController extends Controller
{
    public function createLaporan(Request $request){
         // Validate
     
             $image = $request->json('img');
             $image = str_replace('data:image/jpeg;base64,', '', $image);
             $image = str_replace(' ', '+', $image);         
             $imageName = 'image_'.time().str_random(10).'.png';
             Storage::disk('public')->put($imageName, base64_decode($image));     
    

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

           $result_photo = Photo::create([
             'laporan_id' => $result_laporan->id,
             'photo' => $imageName,
           ]);

           if($result_laporan && $result_location && $result_photo){
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

    public function showImage($image_name){
    /*     echo 'Hello world';
        Storage::disk('public')->put('file.txt','Hello world'); */
     return view('showImage');
/* 
       $path = storage_path('app/' . 'image_15674207359iGE8T6nE2.png');

    if (!File::exists($path)) {
        return 404;
    }

    $type = File::mimeType($path);
    $headers = array('Content-Type' => $type);
    $response = response()->download($path, $photo, $headers);
    ob_end_clean();
    return $response; */

   
    }

    public function writeFile()
    {
        echo 'Hello world';
        Storage::disk('public')->put('file.txt','Hello world');
    }

    public function readFile(){
        $data = Storage::disk('public')->get('file.txt');
        var_dump($data);

        //$data = Storage::disk('public')->get('image_1567429473Lcng6Oz059.png');

        $url = "http://localhost/pantau/storage/app/public/image_1567429473Lcng6Oz059.png";
        return "<img src='".$url."'/>";
      
        return response()->json(['error' => false, 'url' => $url]);



    }
}
