<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RssFeedItem extends Model
{
    /** @use HasFactory<\Database\Factories\RssFeedItemFactory> */
    use HasFactory;
    protected $fillable = ['title', 'link', 'description', 'pub_date', 'feed_source_id'];
    public function rssFeed() {
        return $this->belongsTo(RssFeed::class);
    }
}
