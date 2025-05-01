<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    /** @use HasFactory<\Database\Factories\ProductTypeFactory> */
    use HasFactory;
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function asset(){
        return $this->belongsTo(Asset::class);
    }
}
