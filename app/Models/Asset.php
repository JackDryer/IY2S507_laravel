<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    protected $fillable = ["serial_number","colour_id"];
    /** @use HasFactory<\Database\Factories\AssetFactory> */
    use HasFactory;

    public function colour(){
        return $this->belongsTo(Colour::class);
    }
    public function device(){
        return $this->belongsTo(Device::class);
    }
    public function requests(){
        return $this->hasMany(DeviceRequest::class);
    }
}
