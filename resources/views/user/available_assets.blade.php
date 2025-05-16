<x-layout>
    <h2>Loanable assets</h2>
        <table class="custom-list-header">
        <thead>
            <tr>
                <th> @sortablelink('name', 'Name')</th>
                <th>@sortablelink('colour.colour', 'Colour') </th>
            </tr>
        {{-- This feels like there is an easier way --}}
        <tbody>
            @foreach ($assets as  $asset)
            <tr>
            
                    <td class = "custom-list-item"><h3>{{ $asset->name }}</h3></td>
                    <td class = "custom-list-item"><p>{{$asset->colour->colour}} {{$asset->device->name}}</p></td>
                    <td class = "custom-list-item"><form action="{{route("user.request_asset")}}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{$asset->id}}">
                        <button class="btn">Request</button>
                    </form></td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {!! $assets->appends(\Request::except('page'))->render() !!}
</x-layout>