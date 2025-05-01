<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Asset Manager</title>
    @vite("resources/css/app.css")
</head>
<body>
    <header>
        <nav>
            <h1>Asset Manager</h1>
            <a href = "/assets"> View Assets</a>
            <a href = "/assets/create">Create a new asset</a>
        </nav>
    </header>
    <main class="container">
        {{$slot}} 
    </main>
</body>
</html>