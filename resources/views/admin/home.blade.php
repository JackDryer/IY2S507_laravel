<x-layout>
    @if ($user_requests)
        <h1>You have</h1>
        <p>{{$user_requests}} pending <u>
            <a href = "{{ route('admin.user_requests') }}">
                User Requests</a></u></p>
        <p>{{$asset_requests}} pending <u>
            <a href = "{{ route('admin.asset_requests') }}">
                Asset Requests</a></u></p>
    @endif
</x-layout>