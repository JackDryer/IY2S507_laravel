<x-layout>
    <h2>Loanable assets</h2>
        <table class="custom-list-header">
        <thead>
            <tr>
                <th> @sortablelink('name', 'Name')</th>
                <th>@sortablelink('colour.colour', 'Colour',['hii' => 'there, friend'],) </th>
            </tr>
        {{-- This feels like there is an easier way --}}
        <tbody>
            @foreach ($assets as  $asset)
            <tr>
            
                    <td class = "custom-list-item"><h3>{{ $asset->name }}</h3></td>
                    <td class = "custom-list-item"><p>{{$asset->colour->name}} {{$asset->device->name}}</p></td>
                </div>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{$assets->links()}} 
</x-layout>