<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RssFeed;
use App\Models\RssFeedItem;
use Vedmant\FeedReader\Facades\FeedReader;

class RssController extends Controller
{
    public function updateFeeds()
    {
    $feeds = RssFeed::all();

    foreach ($feeds as $source) {
        $feed = FeedReader::read($source->url);

        foreach ($feed->get_items() as $item) {
            RssFeedItem::updateOrCreate(
                ['link' => $item->get_permalink()],
                [
                    'title' => $item->get_title(),
                    'description' => $item->get_description(),
                    'pub_date' => $item->get_date('Y-m-d H:i:s'),
                    'feed_source_id' => $source->id,
                ]
            );
        }
    }
}
}
