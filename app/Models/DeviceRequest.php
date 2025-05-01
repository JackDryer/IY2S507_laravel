<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeviceRequest extends Model
{
    /** @use HasFactory<\Database\Factories\DeviceRequestFactory> */
    use HasFactory; 
    public function asset(){
        return $this->belongsTo(Asset::class);
    }
    public function device(){
        return $this->belongsTo(Device::class);
    }
}
