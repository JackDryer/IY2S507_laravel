<x-layout>
<div class="container">
    <h1 class="mb-4">RSS Feeds</h1>

    @forelse($feeds as $feed)
        <div class="card mb-4">
            <div class="card-header">
                <h2>{{ $feed->title }}</h2>
                <small class="text-muted">{{ $feed->url }}</small>
            </div>
            <div class="card-body">
                @forelse($feed->rssFeedItems as $item)
                    <div class="mb-3 pb-3 border-bottom">
                        <h5><a href="{{ $item->link }}" target="_blank">{{ $item->title }}</a></h5>
                        <div>{{ $item->description }}</div>
                        <small class="text-muted">Published: {{ $item->published_at }}</small>
                    </div>
                @empty
                    <p>No items in this feed.</p>
                @endforelse
            </div>
        </div>
    @empty
        <div class="alert alert-info">No feeds available.</div>
    @endforelse
</x-layout>