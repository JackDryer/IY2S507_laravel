<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RssFeed extends Model
{
    /** @use HasFactory<\Database\Factories\RssFeedFactory> */
    use HasFactory;
    protected $fillable = ['name', 'url', 'category'];
    public function rssFeedItems() {
        return $this->hasMany(RssFeedItem::class);
    }
}

