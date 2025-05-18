<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Brand extends Model
{
    /** @use HasFactory<\Database\Factories\BrandFactory> */
    use HasFactory, Sortable;
    protected $sortable = ["brand"]; 
    public function cpus(){
        return $this->hasMany(Cpu::class);
    }
    public function devices(){
        return $this->hasMany(Device::class);
    }
}
