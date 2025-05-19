<tbody  x-data="{ open: false }">
    <tr @click="open = !open" class = "cursor-pointer">
        <td><h3>{{$user->name }}</h3></td>
        <td><p>{{$user->email}}</p></td>
        @if($slot->isNotEmpty())
            {{$slot}}
        @endif
    </tr>
    <tr x-show="open" x-transition>
        <td colspan="3" class = "py-4 pl-6 pr-12">
            <table>
                <thead>
                    <tr>
                        <th>Employee No</th>
                        <th>First Name</th>
                        <th>Surname</th>
                        <th>Department</th>
                        <th>Max Devices</th>
                        <th>Status</th> {{--requested, active, disabled--}}
                        <th>Admin?</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{$user->employee_num}}</td>
                        <td>{{$user->first_name}}</td>
                        <td>{{$user->last_name}}</td>
                        <td>{{$user->department->name}}</td>
                        <td>{{$user->device_limit}}</td>
                        <td>{{$user->status}}</td>
                        <td>{{$user->is_admin ? 'yes':'no'}}</td>
                    </tr>
                </tbody>
            </table>
        </td>
    </tr>
</tbody>