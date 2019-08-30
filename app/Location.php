<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $table = 'locations';
    protected $fillable = [
        'laporan_id', 'latitude', 'longitude', 'altitude', 'accuracy'
    ];
    public $timestamps = false;

}
