<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cpu extends Model
{
    protected $fillable = ["name","clock_speed_htz","cache_bytes"];
    /** @use HasFactory<\Database\Factories\CpuFactory> */
    use HasFactory;
    public function brand(){
        return $this->belongsTo(Brand::class);
    }
    public function devices(){
        return $this->hasMany(Device::class);
    }
}
