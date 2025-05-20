<x-layout>
    <div class="container">
        <h1 class="page-title">RSS Feed</h1>
        @forelse($feed as $item)
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
            <div class="empty-feeds">No feeds available.</div>
        @endforelse
    </div>
</x-layout>