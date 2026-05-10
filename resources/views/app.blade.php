<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel Todo App</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">
</head>

<body style="background:#f5f5f5;">

    <nav class="navbar navbar-dark bg-dark mb-4">
        <div class="container">
            <a href="{{ route('todos.index') }}" class="navbar-brand">
                Todo Project
            </a>
        </div>
    </nav>

    <div class="container">
        @yield('content')
    </div>

</body>

</html>