<x-layout>
    <h2>Pending User Requests</h2>
    <table>
        <thead>
            <tr>
                <th> @sortablelink('name', 'Name')</th>
                <th> @sortablelink('email', 'Email')</th>
            </tr>
        </thead>
        {{-- This feels like there is an easier way --}}
        @foreach ($user_requests as  $request)
            <tbody>
                    <td><h3>{{$request->name }}</h3></td>
                    <td><p>{{$request->email}}</p></td>
                    <td>
                        <form action="{{route("admin.approve_user_request")}}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{$request->id}}">
                            <button class="btn btn block mx-auto">Approve</button>
                        </form>
                    </td>
                </tr>
            </tbody>
        @endforeach
    </table>
    {{$user_requests->links()}} 
</x-layout>