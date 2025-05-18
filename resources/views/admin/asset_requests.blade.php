<x-layout>
    <h2>Pending User Requests</h2>
    <table>
        <thead>
            <tr>
                <th> @sortablelink('user.name', 'Name')</th>
                <th> @sortablelink('asset.name', 'Asset name')</th>
            </tr>
        </thead>
        {{-- This feels like there is an easier way --}}
        @foreach ($asset_requests as  $request)
            <tbody x-data="{ open:false }">
                <tr @click="open = !open" class = "cursor-pointer">
                        <td><h3>{{$request->user->name }}</h3></td>
                        <td><p>{{$request->asset->name}}</p></td>
                        <td><form action="{{route("admin.approve_asset_request")}}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{$request->id}}">
                            <button class="btn block mx-auto">Approve</button>
                        </form></td>
                    </div>
                </tr>
                <tr x-show="open" x-transition>
                    <td colspan="2" class = "py-4 pl-6 pr-12">
                        <table>
                            <thead>
                                <tr>
                                    <th>Asset Name</th>
                                    <th>Colour</th>
                                    <th>Device</th>
                                </tr>
                            </thead>
                            <x-expandable-asset :asset="$request->asset" />
                        </table>
                    </td>
                </tr>
            </tbody>
        @endforeach
    </table>
    {{$asset_requests->links()}} 
</x-layout>