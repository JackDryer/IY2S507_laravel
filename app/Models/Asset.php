<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Asset extends Model
{
    protected $fillable = ["serial_number","colour_id","name","device_id"];
    /** @use HasFactory<\Database\Factories\AssetFactory> */
    use HasFactory, Sortable;
    protected $sortable = ["serial_number","name"];
    public function colour(){
        return $this->belongsTo(Colour::class);
    }
    public function device(){
        return $this->belongsTo(Device::class);
    }
    public function requests(){
        return $this->hasMany(AssetRequest::class);
    }
}
