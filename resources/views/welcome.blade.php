<!DOCTYPE html>
<html lang="en" data-theme="light"> <!-- Set the data-theme to light -->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Welcome</title>
    <!-- Include DaisyUI and Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/daisyui@latest/dist/full.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-base-100 flex flex-col min-h-screen">
    <!-- Navbar -->
    <div class="navbar bg-base-100">
        <div class="flex-1">
            <a class="btn btn-ghost normal-case text-xl">STARBHAK Mart</a>
        </div>
        <div class="flex-none">
            @if (Route::has('login'))
                <ul class="menu menu-horizontal px-1">
                    @auth
                        <li><a href="{{ route('redirect.dashboard') }}" class="btn btn-primary">Dashboard</a></li>
                    @else
                        <li><a href="{{ route('login') }}" class="btn btn-primary">Log in</a></li>
                        @if (Route::has('register'))
                            <li><a href="{{ route('register') }}" class="btn btn-secondary ml-2">Register</a></li>
                        @endif
                    @endauth
                </ul>
            @endif
        </div>
    </div>

    <!-- Centered Welcome Message -->
    <div class="flex-grow flex items-center justify-center">
        <div class="text-start">
            <h1 class="text-5xl font-bold mb-4">Welcome to STARBHAK Mart!</h1>
            <p class="text-xl mb-6">Manage your store here!</p>
        </div>
    </div>
</body>
</html>
