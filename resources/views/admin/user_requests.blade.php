<x-layout>
    <h2>Pending User Requests</h2>
    <table class="custom-list-header">
        <thead>
            <tr>
                <th> @sortablelink('name', 'Username')</th>
                <th> @sortablelink('email', 'Email')</th>
            </tr>
        {{-- This feels like there is an easier way --}}
        <tbody>
            @foreach ($user_requests as  $request)
            <tr>
            
                    <td class = "custom-list-item"><h3>{{$request->name }}</h3></td>
                    <td class = "custom-list-item"><p>{{$request->email}}</p></td>
                    <td class = "custom-list-item"><form action="{{route("admin.approve_user_request")}}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{$request->id}}">
                        <button class="btn">Approve</button>
                    </form></td>
                </div>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{$user_requests->links()}} 
</x-layout>