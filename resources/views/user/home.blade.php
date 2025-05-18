<x-layout>
    <h2>Assigned assets</h2>
    <table>
        <x-asset-table-headings/>
            @foreach ($approved_assets as  $asset)
            <x-expandable-asset :asset="$asset"/>
            @endforeach
    </table>
    {!! $approved_assets->appends(\Request::except('page'))->render() !!}
    <br>
    <h2>Pending assets</h2>
    <table>
        <x-asset-table-headings/>
            @foreach ($pending_assets as  $asset)
            <x-expandable-asset :asset="$asset"/>
            @endforeach
    </table>
    {!! $pending_assets->appends(\Request::except('page'))->render() !!}
    <br>
    <a href ="{{route("user.available_assets")}}" class = "btn">Request an Asset</a>
</x-layout>