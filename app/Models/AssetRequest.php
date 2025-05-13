<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetRequest extends Model
{
    /** @use HasFactory<\Database\Factories\AssetRequestFactory> */
    use HasFactory; 
    public function asset(){
        return $this->belongsTo(Asset::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
