<x-layout>
  <form action="{{ route('login') }}" method="POST">
    @csrf

    <h2>Log In to Your Account</h2>

    <label for="email">Email:</label>
    <input 
      type="email"
      name="email"
      value="{{ old('email') }}"
      required
    >

    <label for="password">Password:</label>
    <input 
      type="password"
      name="password"
      required
    >

    <button type="submit" class="btn mt-4">Log in</button>

    <!-- validation errors -->
    @if ($errors->any())
      <ul class="px-4 py-2 bg-red-500">
        @foreach ($errors->all() as $error)
          <li class="my-2 text-black">{{ $error }}</li>
        @endforeach
      </ul>
    @endif
  </form>
</x-layout>