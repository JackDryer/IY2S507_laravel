<x-layout>
    <h2>Assigned assets</h2>
    <table>
        <thead>
            <tr>
                <th> @sortablelink('name', 'Name')</th>
                <th>@sortablelink('colour.colour', 'Colour') </th>
                <th>@sortablelink('device.name', 'Device') </th>
            </tr>
            @foreach ($assets as  $asset)
            <x-expandable-asset :asset="$asset"/>
            @endforeach
    </table>
    {!! $assets->appends(\Request::except('page'))->render() !!}
    <br>
    <a href ="{{route("user.available_assets")}}" class = "btn">Request an Asset</a>
</x-layout>