<x-layout>
    <h2>Assigned assets</h2>
        <table class="custom-list-header">
        <thead>
            <tr>
                <th> @sortablelink('name', 'Name')</th>
                <th>@sortablelink('colour.colour', 'Colour') </th>
            </tr>
        {{-- This feels like there is an easier way --}}
        <!--tbody-->
            @foreach ($assets as  $asset)
                <tbody  x-data="{ open: false }">
                <tr @click="open = !open">
                    <td class = "custom-list-item"><h3>{{ $asset->name }}</h3></td>
                    <td class = "custom-list-item"><p>{{$asset->colour->colour}} {{$asset->device->name}}</p></td>
                </tr>
                <tr x-show="open" x-transition class = "custom-list-item">
                    <td colspan="2">CPU: {{$asset->device->cpu->name}}</td>
                </tr>
                <!--/tbody-->
            @endforeach
        </tbody>
    </table>
    {!! $assets->appends(\Request::except('page'))->render() !!}
    <br>
    <a href ="{{route("user.available_assets")}}" class = "btn">Request an Asset</a>
</x-layout>