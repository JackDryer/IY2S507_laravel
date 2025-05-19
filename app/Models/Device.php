<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Device extends Model
{
    /** @use HasFactory<\Database\Factories\DeviceFactory> */
    use HasFactory, Sortable;

    protected $fillable = ["name", "ram_bytes","storage_bytes", "brand_id", "cpu_id", "product_type_id"];

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
