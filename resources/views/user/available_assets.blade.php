<x-layout>
    <h2>Loanable assets</h2>
    <table>
        <thead>
            <tr>
                <th> @sortablelink('name', 'Name')</th>
                <th>@sortablelink('colour.colour', 'Colour') </th>
                <th>@sortablelink('device.name', 'Device') </th>
            </tr>
        </thead>
            @foreach ($assets as  $asset)
                <x-expandable-asset :asset="$asset">
                    <form action="{{route("user.request_asset")}}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{$asset->id}} open">
                        <td class="justify-center"> 
                            <button class="btn block mx-auto" @click.stop="open">Request</button>
                        </td>
                    </form>
                </x-expandable-asset>
            @endforeach
    </table>
    {!! $assets->appends(\Request::except('page'))->render() !!}
</x-layout>