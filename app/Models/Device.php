<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    /** @use HasFactory<\Database\Factories\DeviceFactory> */
    use HasFactory;
    public function cpu(){
        return $this->belongsTo(Cpu::class);
    }
    public function brand(){
        return $this->belongsTo(Brand::class);
    }
    public function productType(){
        return $this->belongsTo(ProductType::class);
    }
    public function assets(){
        return $this->hasMany(Asset::class);
    }
}
