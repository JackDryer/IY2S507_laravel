<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Colour extends Model
{
    /** @use HasFactory<\Database\Factories\ColourFactory> */
    use HasFactory, Sortable;
    protected $sortable = ["name"];
    protected $fillable = ["name"];
    public function assets(){
        return $this->hasMany(Asset::class);
    }
}
