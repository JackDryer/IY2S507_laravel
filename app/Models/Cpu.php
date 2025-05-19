<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Cpu extends Model
{
    protected $fillable = ["name","base_clock_speed_hz","brand_id","cores"];
    /** @use HasFactory<\Database\Factories\CpuFactory> */
    use HasFactory, Sortable;
    protected $sortable = ["name","base_clock_speed_hz","cores"];
    
    public function brand(){
        return $this->belongsTo(Brand::class);
    }
    public function devices(){
        return $this->hasMany(Device::class);
    }
}
