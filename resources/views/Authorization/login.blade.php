<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@latest/dist/full.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-base-100 flex flex-col min-h-screen">
    <!-- Navbar -->
    <div class="navbar bg-base-100">
        <div class="flex-1">
            <a class="btn btn-ghost normal-case text-xl">STARBHAK Mart</a>
        </div>
    </div>

    <!-- Login Form -->
    <div class="flex-grow flex items-center justify-center">
        <div class="card w-96 bg-base-200 shadow-xl">
            <div class="card-body">
                <h2 class="card-title mb-4">Login</h2>
                <form action="" method="post">
                    @csrf
                    @if ($errors->any())
                        <div class="alert alert-error">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('message') }}
                        </div>
                    @endif
                    <div class="form-control">
                        <label class="label" for="username">
                            <span class="label-text">Username</span>
                        </label>
                        <input type="text" id="username" name="username" class="input input-bordered" required/>
                    </div>
                    <div class="form-control mt-4">
                        <label class="label" for="password">
                            <span class="label-text">Password</span>
                        </label>
                        <input type="password" id="password" name="password" class="input input-bordered" required/>
                    </div>
                    <div class="form-control mt-6">
                        <button type="submit" class="btn btn-primary">Sign in</button>
                    </div>
                </form>
                <div class="text-center mt-4">
                    <span>Don't have an account?</span>
                    <a href="/register" class="link link-primary">Register</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>