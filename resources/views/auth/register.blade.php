<x-layout>
  <form action="{{ route('register') }}" method="POST">
    @csrf

    <h2>Register for an Account</h2>

    <label for="name">Username:</label>
    <input 
      type="text"
      name="name"
      value="{{ old('name') }}"
      required
    >

    <label for="email">Email:</label>
    <input 
      type="email"
      name="email"
      value="{{ old('email') }}"
      required
    >
    <label for="employee_num">Employee No:</label>
    <input 
      type="text"
      name="employee_num"
      value="{{ old('employee_num') }}"
      required
    >
    <label for="first_name">First name:</label>
    <input 
      type="text"
      name="first_name"
      value="{{ old('first_name') }}"
      required
    >
    <label for="last_name">Surname:</label>
    <input 
      type="text"
      name="last_name"
      value="{{ old('last_name') }}"
      required
    >
    <label for="department_id">Department:</label>
    <select id="department_id" name="department_id" required>
      <option value="" disabled selected>Select a department</option>
      @foreach ($departments as $department)
        <option value="{{ $department->id }}" {{ $department->id == old('department_id') ? 'selected' : '' }}>
          {{ $department->name }}
        </option>
      @endforeach
    </select>
    <label for="password">Password:</label>
    <input 
      type="password"
      name="password"
      required
    >

    <label for="password_confirmation">Password:</label>
    <input 
      type="password"
      name="password_confirmation"
      required
    >

    <button type="submit" class="btn mt-4">Register</button>

    <!-- validation errors -->
    @if ($errors->any())
      <ul class="px-4 py-2 bg-red-100">
        @foreach ($errors->all() as $error)
          <li class="my-2 text-red-500">{{ $error }}</li>
        @endforeach
      </ul>
    @endif
    
  </form>
</x-layout>