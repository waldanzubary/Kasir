<!DOCTYPE html>
<html lang="en" data-theme="light"> <!-- Set the data-theme to light -->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@latest/dist/full.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .login-card {
            display: flex;
            height: 500px; /* Set a fixed height for the card */
            border-radius: 1rem;
            overflow: hidden; /* Hide overflow for rounded corners */
            opacity: 0;
            animation: fadeIn 1s forwards; /* Fade in animation */
        }

        .left-side {
            background-color: rgb(75, 80, 77); /* Yellow background */
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            text-align: center;
            transform: translateX(-20px); /* Start from left */
            animation: slideIn 1s forwards; /* Slide in animation */
        }

        .left-side img {
            max-width: 80%;
            height: auto;
            margin-bottom: 1rem;

        }

        .left-side h2 {
            font-size: 1.2rem;
            font-family: monospace;
            white-space: nowrap;
            overflow: hidden;
            border-right: .15em solid orange; /* Cursor effect */
            animation: typing 3.5s steps(40, end), blink-caret .75s step-end infinite; /* Typing and cursor blinking animations */
        }

        .right-side {
            flex: 1;
            background-color: #ffffff; /* White background */
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 2rem;
        }

        .right-side .form-control {
            margin-top: 1rem;
            opacity: 0;
            animation: fadeInUp 1s forwards; /* Fade in and move up animation */
        }

        .right-side .btn-primary {
            margin-top: 1rem;
            transition: background-color 0.3s ease; /* Smooth color transition */
        }

        .right-side .btn-primary:hover {
            background-color: #fbbf24; /* Change color on hover */
        }

        @keyframes fadeIn {
            to {
                opacity: 1;
            }
        }

        @keyframes slideIn {
            to {
                transform: translateX(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateY(0);
            }
            40% {
                transform: translateY(-30px);
            }
            60% {
                transform: translateY(-15px);
            }
        }

        @keyframes typing {
            from { width: 0; }
            to { width: 100%; }
        }

        @keyframes blink-caret {
            from, to { border-color: transparent; }
            50% { border-color: green; }
        }
    </style>
</head>
<body class="bg-base-100 flex flex-col min-h-screen">

    <!-- Login Card -->
    <div class="flex-grow flex items-center justify-center">
        <div class="login-card shadow-xl">
            <!-- Left Side -->
            <div class="left-side">
                <img src="assets/img/cashier.png" alt="Cashier" />
                <h2 style="color: white">Manage Your UMKM Store Efficiently!</h2>
            </div>

            <!-- Right Side -->
            <div class="right-side">
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
                        <!-- Forgot Password Link -->
                        <div class="text-right mt-2">
                            <a href="/forgot-password" class="link link-primary">Forgot Password?</a>
                        </div>
                        <div class="form-control mt-6">
                            <button type="submit" class="btn mt-3" style="background-color: rgb(75, 80, 77); color: white">Sign in</button>
                        </div>
                    </form>
                    <div class="text-center mt-4">
                        <span>Don't have an account?</span>
                        <a href="/register" class="link link-primary">Register</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
