<x-layout>
    <h2>Pending User Requests</h2>
    <ul>
        @foreach ($user_requests as  $request)
        <li>
            
            <div class = "list-item">
                <h3>{{$request->name }}</h3>
                <p>{{$request->email}}</p>
                <form action="{{route("admin.approve_user_request")}}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{$request->id}}">
                    <button class="btn">Approve</button>
                </form>
            </div>
            
        </li>
        @endforeach
    </ul>
    {{$user_requests->links()}} 
</x-layout>