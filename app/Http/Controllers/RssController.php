<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RssFeed;
use App\Models\RssFeedItem;
use Illuminate\Support\Facades\Log;
use Vedmant\FeedReader\Facades\FeedReader;

class RssController extends Controller
{
    public static function updateFeeds()
    {
    Log::info('reading feed');
    $feeds = RssFeed::all();

    foreach ($feeds as $source) {
        $feed = FeedReader::read($source->url);
        Log::info('reading feed', ['feed' => $source->url]);
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

/**
 * Display a listing of RSS feeds
 * 
 * @return \Illuminate\View\View
 */
public function index()
{
    // Assuming you have a Feed model - adjust as needed for your actual data structure
    $feed = RssFeedItem::orderBy("pub_date", "desc")
        ->paginate(20);
    
    return view('rss.index', compact('feed'));
}

/**
 * Show the form for creating a new RSS feed
 * 
 * @return \Illuminate\View\View
 */
public function create()
{
    return view('rss.create');
}

/**
 * Store a newly created RSS feed
 * 
 * @param \Illuminate\Http\Request $request
 * @return \Illuminate\Http\RedirectResponse
 */
public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255|unique:rss_feeds,name',
        'url' => 'required|url|unique:rss_feeds,url',
        'category' => 'nullable|string|max:255',
    ]);
    
    RssFeed::create($validated);
    
    return redirect()->route('feeds.index')
        ->with('success', 'RSS feed added successfully!');
}
}
