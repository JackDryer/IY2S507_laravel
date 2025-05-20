<x-layout>
    <div class="container mx-auto py-6 px-4">
        <div class="flex justify-center">
            <div class="w-full max-w-4xl">
                <div class="bg-slate-700 rounded-lg shadow-md overflow-hidden">
                    <div class="bg-slate-800 px-6 py-4">
                        <h4 class="text-xl font-medium">{{ __('User Profile') }}</h4>
                    </div>

                    <div class="p-6">
                        <form method="POST" action="{{ route('profile.update') }}">
                            @csrf
                            @method('PUT')

                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                                <div>
                                    <!-- Personal Information Section -->
                                    <h5 class="text-lg font-medium mb-4 pb-2 border-b border-gray-200">Personal Information</h5>
                                    
                                    <div class="mb-4">
                                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Username') }}</label>
                                        <input id="name" type="text" 
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 {{ $errors->has('name') ? 'border-red-500' : '' }}"
                                            name="name" value="{{ old('name', $user->name) }}" required autocomplete="name" autofocus>
                                        @error('name')
                                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">{{ __('E-Mail Address') }}</label>
                                        <input id="email" type="email" 
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 {{ $errors->has('email') ? 'border-red-500' : '' }}"
                                            name="email" value="{{ old('email', $user->email) }}" required autocomplete="email">
                                        @error('email')
                                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label for="first_name" class="block text-sm font-medium text-gray-700 mb-1">{{ __('First Name') }}</label>
                                        <input id="first_name" type="text" 
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 {{ $errors->has('first_name') ? 'border-red-500' : '' }}"
                                            name="first_name" value="{{ old('first_name', $user->first_name) }}" required>
                                        @error('first_name')
                                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label for="last_name" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Last Name') }}</label>
                                        <input id="last_name" type="text" 
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 {{ $errors->has('last_name') ? 'border-red-500' : '' }}"
                                            name="last_name" value="{{ old('last_name', $user->last_name) }}" required>
                                        @error('last_name')
                                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div>
                                    <!-- Employment Information Section -->
                                    <h5 class="text-lg font-medium mb-4 pb-2 border-b border-gray-200">Employment Information</h5>
                                    
                                    <div class="mb-4">
                                        <label for="employee_num" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Employee Number') }}</label>
                                        <input id="employee_num" type="text" 
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 {{ $errors->has('employee_num') ? 'border-red-500' : '' }}"
                                            name="employee_num" value="{{ old('employee_num', $user->employee_num) }}" required>
                                        @error('employee_num')
                                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label for="department_id" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Department') }}</label>
                                        <select id="department_id" 
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 {{ $errors->has('department_id') ? 'border-red-500' : '' }}"
                                            name="department_id" required>
                                            @foreach($departments as $department)
                                                <option value="{{ $department->id }}" {{ old('department_id', $user->department_id) == $department->id ? 'selected' : '' }}>
                                                    {{ $department->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('department_id')
                                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    
                                    <!-- Password Section -->
                                    <h5 class="text-lg font-medium mt-6 mb-4 pb-2 border-b border-gray-200">Change Password</h5>
                                    
                                    <div class="mb-4">
                                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">{{ __('New Password') }}</label>
                                        <input id="password" type="password" 
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 {{ $errors->has('password') ? 'border-red-500' : '' }}"
                                            name="password" autocomplete="new-password">
                                        <p class="text-gray-500 text-sm mt-1">Leave blank to keep your current password</p>
                                        @error('password')
                                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label for="password-confirm" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Confirm Password') }}</label>
                                        <input id="password-confirm" type="password" 
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"
                                            name="password_confirmation" autocomplete="new-password">
                                    </div>
                                </div>
                            </div>

                            <div class="flex justify-end mt-6">
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                                    </svg>
                                    {{ __('Update Profile') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>