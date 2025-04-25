<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>mogitate</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">

    <style>
    .logo {
        font-family: 'Pacifico', cursive;
    }
    </style>


</head>


<body class="bg-gray-50 text-gray-800 sticky top-0 z-10">
    <header class="bg-white shadow p-4 mb-6 sticky top-0 z-10">
         <div class="max-w-7xl mx-auto px-4 flex items-center justify-between">
            <h1 class="text-2xl logo text-green-600">Mogitate</h1>
        </div>
    </header>

    <main class="container mx-auto">
        @yield('content')
    </main>
</body>
</html>
