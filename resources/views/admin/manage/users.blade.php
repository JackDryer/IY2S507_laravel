<x-layout>
    <h2>Users</h2>
    <table>
        <thead>
            <tr>
                <th> @sortablelink('name', 'Name')</th>
                <th> @sortablelink('email', 'Email')</th>
            </tr>
        </thead>
        {{-- This feels like there is an easier way --}}
        @foreach ($users as  $user)
            <x-expandable-user-form :user="$user">
                <td>
                    <form action="{{route("admin.approve_user_request")}}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{$user->id}}">
                        <button class="btn btn block mx-auto">Approve</button>
                    </form>
                </td>
            </x-expandable-user-form>
        @endforeach
    </table>
    {{$users->links()}} 
</x-layout>