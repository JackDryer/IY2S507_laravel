<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Asset Manager</title>
    @vite(["resources/css/app.css","resources/js/app.js"])
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <header>
        <nav>
            <h1>Asset Manager</h1>
            @guest
            <a href = {{ route('login.show') }} class = "btn">Login</a>
            <a href = {{ route('register.show') }} class = "btn">Register</a>
            @endguest
            @auth
            <span class = "border-r-2 pr-2">
                {{Auth::user()->name}}
            </span>
            <a href = "{{route("user.home")}}" > My Assets</a>
            <a href = "{{route("feeds.index")}}" > RSS Feed</a>
            <a href = "{{route("profile")}}" > Profile</a>
            @admin
              <a href = "{{route('admin.home')}}">Admin</a>  
            @endadmin
            <form action="{{route("logout")}}" method="POST">
                @csrf
                <button class="btn">Logout</button>
            </form>
            @endauth
        </nav>
    @if (session('success'))
        <div class="flashbox" role="alert">
            <p class="font-bold">{{session('success')}}</p>
        </div>
    @endif
    </header>
    <main class="container">
        {{$slot}} 
    </main>
</body>
</html>