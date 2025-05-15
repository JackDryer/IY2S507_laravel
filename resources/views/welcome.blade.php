<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asset Manager</title>
    @vite("resources/css/app.css")
</head>
<body class = "text-center p-08 py-12">
    @if (session('success'))
    <div class="bg-blue-100 border-t border-b border-blue-500 text-blue-700 px-4 py-3" role="alert">
        <p class="font-bold">{{session('success')}}</p>
    </div>
    @endif
    <h1> Asset Management as you've never seen it before </h1>
    <p>Unless you've done nothing but look at asset managers for some reason</p>
    <a href = "/assets" class="btn">
    Log in
    </a>
</body>
</html>