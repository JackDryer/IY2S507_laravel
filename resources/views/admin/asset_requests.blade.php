<x-layout>
    <h2>Pending User Requests</h2>
    <table class="custom-list-header">
        <thead>
            <tr>
                <th> @sortablelink('user.name', 'Name')</th>
                <th> @sortablelink('asset.name', 'Asset name')</th>
            </tr>
        {{-- This feels like there is an easier way --}}
        <tbody>
            @foreach ($asset_requests as  $request)
            <tr>
            
                    <td class = "custom-list-item"><h3>{{$request->user->name }}</h3></td>
                    <td class = "custom-list-item"><p>{{$request->asset->name}}</p></td>
                    <td class = "custom-list-item"><form action="{{route("admin.approve_asset_request")}}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{$request->id}}">
                        <button class="btn">Approve</button>
                    </form></td>
                </div>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{$asset_requests->links()}} 
</x-layout>