<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    protected $table = 'laporans';
    protected $fillable = [
        'user_id',
        'judul',
        'kategori_id',
        'deskripsiLaporan',
        'namaPerusahaan', 
        'desaKelurahan',
        'kecamatan', 
        'kotaKabupaten', 
        'provinsi', 
        'status_id' ,
        'created_at',
        'updated_at'
    ];

}
