<x-layout>
    <div class = "flex items-center col-span-3">
        <div class="px-4">
            @if ($user_requests|$asset_requests)
                <h1>You have</h1>
                <p>{{$user_requests}} pending <u>
                    <a href = "{{ route('admin.user_requests') }}">
                        User Requests</a></u></p>
                <p>{{$asset_requests}} pending <u>
                    <a href = "{{ route('admin.asset_requests') }}">
                        Asset Requests</a></u></p>
            @endif
        </div>
        <div>
            <h1>Manage</h1>
            <u>
                <a href = "{{ route('admin.manage_users') }}">
                    <p>Users</p>
                </a>
                <a href = "{{ route('admin.manage_assets') }}">
                    <p>Assets</p>
                </a>
            </u>
        </div>
    </div>
</x-layout>