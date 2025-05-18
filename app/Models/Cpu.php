<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Cpu extends Model
{
    protected $fillable = ["name","clock_speed_htz","cache_bytes"];
    /** @use HasFactory<\Database\Factories\CpuFactory> */
    use HasFactory, Sortable;
    protected $sortable = ["name","clock_speed_htz","cache_bytes"];
    
    public function brand(){
        return $this->belongsTo(Brand::class);
    }
    public function devices(){
        return $this->hasMany(Device::class);
    }
}
