<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Colour extends Model
{
    /** @use HasFactory<\Database\Factories\ColourFactory> */
    use HasFactory;
    public function assets(){
        return $this->hasMany(Asset::class);
    }
}
