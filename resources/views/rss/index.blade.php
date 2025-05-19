<x-layout>
    <div class="container">
        <h1 class="page-title">RSS Feeds</h1>

        @forelse($feeds as $feed)
            <div class="feed-card">
                <div class="feed-header">
                    <h2>{{ $feed->name }}</h2>
                    <div class="feed-meta">
                        <span class="feed-url">{{ $feed->url }}</span>
                        @if($feed->category)
                            <span class="feed-category">{{ $feed->category }}</span>
                        @endif
                    </div>
                </div>
                <div class="feed-body">
                    @forelse($feed->rssFeedItems as $item)
                        <div class="feed-item">
                            <h3 class="feed-item-title">
                                <a href="{{ $item->link }}" target="_blank" rel="noopener">
                                    {{ $item->title }}
                                </a>
                            </h3>
                            <div class="feed-item-content">
                                {!! $item->description !!}
                            </div>
                            <div class="feed-item-date">
                                Published: {{ \Carbon\Carbon::parse($item->pub_date)->format('M d, Y - g:i A') }}
                            </div>
                        </div>
                    @empty
                        <p class="empty-message">No items in this feed.</p>
                    @endforelse
                </div>
            </div>
        @empty
            <div class="empty-feeds">No feeds available. Add some RSS feeds to get started!</div>
        @endforelse
    </div>
</x-layout>