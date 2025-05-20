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
            <x-expandable-user :user="$request">
                <td>
                    <form action="{{route("admin.approve_user_request")}}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{$request->id}}">
                        <button class="btn block mx-auto" @click.stop="open">Approve</button>
                    </form>
                </td>
                <td>
                    <form action="{{route("admin.deny_user_request")}}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{$request->id}}">
                        <button class="btn block mx-auto" @click.stop="open">Deny</button>
                    </form>
                </td>
            </x-expandable-user>
        @endforeach
    </table>
    {{$user_requests->links()}} 
</x-layout>