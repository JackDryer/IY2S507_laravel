<x-layout>
    <div class="container-fluid mx-auto px-1">
        <h1 class="text-xl font-bold mb-3">Manage Users</h1>

        <!-- Search/Filter Controls -->
        <div class="mb-3 flex flex-wrap gap-1">
            <form method="GET" action="{{ route('admin.manage_users') }}" class="flex flex-wrap gap-1">
                <input type="text" name="search" placeholder="Search users..." 
                       class="px-2 py-1 border rounded text-xs" value="{{ request('search') }}">
                <select name="status" class="px-2 py-1 border rounded text-xs">
                    <option value="">All Status</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="requested" {{ request('status') == 'requested' ? 'selected' : '' }}>Requested</option>
                    <option value="denied" {{ request('status') == 'denied' ? 'selected' : '' }}>Denied</option>
                </select>
                <button type="submit" class="bg-blue-500 text-white px-2 py-1 rounded text-xs">Filter</button>
                <a href="{{ route('admin.manage_users') }}" class="bg-gray-500 text-white px-2 py-1 rounded text-xs">Reset</a>
            </form>
        </div>

        <div class="overflow-x-auto bg-white rounded-lg shadow">
            <table class="w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-2 py-1 text-xs font-medium text-left">#</th>
                        <th class="px-2 py-1 text-xs font-medium text-left">Emp #</th>
                        <th class="px-2 py-1 text-xs font-medium text-left">Name</th>
                        <th class="px-2 py-1 text-xs font-medium text-left">Email</th>
                        <th class="px-2 py-1 text-xs font-medium text-left">Dept</th>
                        <th class="px-2 py-1 text-xs font-medium text-left">Limit</th>
                        <th class="px-2 py-1 text-xs font-medium text-left">Status</th>
                        <th class="px-2 py-1 text-xs font-medium text-left">Admin</th>
                        <th class="px-2 py-1 text-xs font-medium text-left">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($users as $user)
                        <tr class="hover:bg-gray-50" x-data="{ 
                            editMode: false,
                            userFirstName: '{{ $user->first_name }}',
                            userLastName: '{{ $user->last_name }}',
                            userEmail: '{{ $user->email }}',
                            userEmployeeNum: '{{ $user->employee_num }}',
                            userDepartment: '{{ $user->department_id }}',
                            userDeviceLimit: '{{ $user->device_limit }}',
                            userStatus: '{{ $user->status }}',
                            userIsAdmin: {{ $user->is_admin ? 'true' : 'false' }}
                        }">
                            <td class="px-2 py-1 text-xs whitespace-nowrap">{{ $user->id }}</td>
                            
                            <td class="px-2 py-1 text-xs whitespace-nowrap">
                                <span x-show="!editMode" x-on:click="editMode = true" class="cursor-pointer hover:text-blue-600">{{ $user->employee_num }}</span>
                                <input x-show="editMode" type="text" x-model="userEmployeeNum" class="w-full text-xs border rounded py-0.5 px-1">
                            </td>
                            
                            <td class="px-2 py-1 text-xs whitespace-nowrap">
                                <span x-show="!editMode" x-on:click="editMode = true" class="cursor-pointer hover:text-blue-600">{{ $user->first_name }} {{ $user->last_name }}</span>
                                <div x-show="editMode" class="flex space-x-1">
                                    <input type="text" x-model="userFirstName" placeholder="First" class="w-1/2 text-xs border rounded py-0.5 px-1">
                                    <input type="text" x-model="userLastName" placeholder="Last" class="w-1/2 text-xs border rounded py-0.5 px-1">
                                </div>
                            </td>
                            
                            <td class="px-2 py-1 text-xs whitespace-nowrap">
                                <span x-show="!editMode" x-on:click="editMode = true" class="cursor-pointer hover:text-blue-600 truncate max-w-[120px] inline-block">{{ $user->email }}</span>
                                <input x-show="editMode" type="email" x-model="userEmail" class="w-full text-xs border rounded py-0.5 px-1">
                            </td>
                            
                            <td class="px-2 py-1 text-xs whitespace-nowrap">
                                <span x-show="!editMode" x-on:click="editMode = true" class="cursor-pointer hover:text-blue-600">{{ $user->department->name ?? 'Unknown' }}</span>
                                <select x-show="editMode" x-model="userDepartment" class="w-full text-xs border rounded py-0.5 px-1">
                                    @foreach($departments ?? [] as $department)
                                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            
                            <td class="px-2 py-1 text-xs whitespace-nowrap">
                                <span x-show="!editMode" x-on:click="editMode = true" class="cursor-pointer hover:text-blue-600">{{ $user->device_limit }}</span>
                                <input x-show="editMode" type="number" x-model="userDeviceLimit" min="0" class="w-full text-xs border rounded py-0.5 px-1">
                            </td>
                            
                            <td class="px-2 py-1 text-xs whitespace-nowrap">
                                <span x-show="!editMode" x-on:click="editMode = true" class="cursor-pointer hover:text-blue-600">
                                    <span class="px-1.5 py-0.5 text-xs rounded-full {{ $user->status == 'active' ? 'bg-green-100 text-green-800' : 
                                        ($user->status == 'requested' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                        {{ ucfirst($user->status) }}
                                    </span>
                                </span>
                                <select x-show="editMode" x-model="userStatus" class="w-full text-xs border rounded py-0.5 px-1">
                                    <option value="requested">Requested</option>
                                    <option value="active">Active</option>
                                    <option value="denied">Denied</option>
                                </select>
                            </td>
                            
                            <td class="px-2 py-1 text-xs whitespace-nowrap">
                                <span x-show="!editMode" x-on:click="editMode = true" class="cursor-pointer hover:text-blue-600">
                                    {{ $user->is_admin ? 'Yes' : 'No' }}
                                </span>
                                <select x-show="editMode" x-model="userIsAdmin" class="w-full text-xs border rounded py-0.5 px-1">
                                    <option value="true">Yes</option>
                                    <option value="false">No</option>
                                </select>
                            </td>
                            
                            <td class="px-2 py-1 text-xs whitespace-nowrap">
                                <div x-show="!editMode" class="flex gap-1">
                                    <button @click="editMode = true" class="bg-blue-500 hover:bg-blue-700 text-white text-xs py-0.5 px-1.5 rounded">
                                        Edit
                                    </button>
                                    <form action="{{ route('admin.manage_user') }}" method="POST" class="inline">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $user->id }}">
                                        <button type="submit" name="action" value="toggle_status" class="bg-yellow-500 hover:bg-yellow-700 text-white text-xs py-0.5 px-1.5 rounded">
                                            {{ $user->status == 'active' ? 'Deact' : 'Act' }}
                                        </button>
                                    </form>
                                </div>
                                
                                <div x-show="editMode" class="flex flex-col gap-1">
                                    <div class="flex gap-1">
                                        <button @click="
                                            fetch('{{ route('admin.manage_user') }}', {
                                                method: 'POST',
                                                headers: {
                                                    'Content-Type': 'application/json',
                                                    'Accept': 'application/json',
                                                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                                                },
                                                body: JSON.stringify({
                                                    id: {{ $user->id }},
                                                    first_name: userFirstName,
                                                    last_name: userLastName,
                                                    email: userEmail,
                                                    employee_num: userEmployeeNum,
                                                    department_id: userDepartment,
                                                    device_limit: userDeviceLimit,
                                                    status: userStatus,
                                                    is_admin: userIsAdmin === 'true',
                                                    action: 'update'
                                                })
                                            })
                                            .then(response => {
                                                if (!response.ok) {
                                                    return response.json().then(err => {
                                                        throw new Error(err.message || 'Update failed');
                                                    });
                                                }
                                                return response.json();
                                            })
                                            .then(data => {
                                                if(data.success) {
                                                    editMode = false;
                                                    window.location.reload();
                                                }
                                            })
                                            .catch(error => {
                                                alert('Error: ' + error.message);
                                            })" 
                                            class="bg-green-500 hover:bg-green-700 text-white text-xs py-0.5 px-1.5 rounded flex-1">
                                            Save
                                        </button>
                                        <button type="button" @click="
                                            editMode = false; 
                                            userFirstName = '{{ $user->first_name }}';
                                            userLastName = '{{ $user->last_name }}';
                                            userEmail = '{{ $user->email }}';
                                            userEmployeeNum = '{{ $user->employee_num }}';
                                            userDepartment = '{{ $user->department_id }}';
                                            userDeviceLimit = '{{ $user->device_limit }}';
                                            userStatus = '{{ $user->status }}';
                                            userIsAdmin = {{ $user->is_admin ? 'true' : 'false' }};
                                        " class="bg-gray-500 hover:bg-gray-700 text-white text-xs py-0.5 px-1.5 rounded flex-1">
                                            Cancel
                                        </button>
                                    </div>
                                    <form action="{{ route('admin.manage_user') }}" method="POST" class="inline">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $user->id }}">
                                        <button type="submit" name="action" value="strip_assets" class="bg-red-500 hover:bg-red-700 text-white text-xs py-0.5 px-1.5 rounded w-full">
                                            Strip Assets
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $users->appends(request()->except('page'))->links() }}
        </div>
    </div>
</x-layout>