<!DOCTYPE html>
<html lang="en" data-theme="light"> <!-- Set the data-theme to light -->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@latest/dist/full.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .form-step { display: none; }
        .form-step.active { display: block; }
    </style>
</head>
<body class="bg-base-100 flex flex-col min-h-screen">
    <!-- Navbar -->
    <div class="navbar bg-base-100">
        <div class="flex-1">
            <a class="btn btn-ghost normal-case text-xl" href="/">STARBHAK Mart</a>
        </div>
    </div>

    <!-- Register Form -->
    <div class="flex-grow flex items-center justify-center">
        <div class="card w-96 bg-base-200 shadow-xl">
            <div class="card-body">
                <h2 class="card-title mb-4">Register</h2>
                <form id="register-form" action="" method="post">
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
                    
                    <!-- Step 1: Email, Username, Password -->
                    <div class="form-step active" id="step-1">
                        <div class="form-control">
                            <label class="label" for="email">
                                <span class="label-text">Email</span>
                            </label>
                            <input type="email" id="email" name="email" class="input input-bordered" required/>
                        </div>
                        <div class="form-control mt-4">
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
                            <button type="button" id="next-btn" class="btn btn-primary">Next</button>
                        </div>
                    </div>
                    
                    <!-- Step 2: Remaining Fields -->
                    <div class="form-step" id="step-2">
                        <div class="form-control">
                            <label class="label" for="phone">
                                <span class="label-text">Phone</span>
                            </label>
                            <input type="text" id="phone" name="phone" class="input input-bordered" required/>
                        </div>
                        <div class="form-control mt-4">
                            <label class="label" for="city">
                                <span class="label-text">City</span>
                            </label>
                            <input type="text" id="city" name="city" class="input input-bordered" required/>
                        </div>
                        <div class="form-control mt-4">
                            <label class="label" for="address">
                                <span class="label-text">Address</span>
                            </label>
                            <textarea id="address" name="address" class="input input-bordered" required></textarea>
                        </div>
                        <div class="form-control mt-4">
                            <label class="label" for="zip_code">
                                <span class="label-text">Zip Code</span>
                            </label>
                            <input type="text" id="zip_code" name="zip_code" class="input input-bordered" required/>
                        </div>
                        <div class="form-control mt-4">
                            <label class="label" for="shop_name">
                                <span class="label-text">Shop Name</span>
                            </label>
                            <input type="text" id="shop_name" name="shop_name" class="input input-bordered" required/>
                        </div>
                        <div class="form-control mt-6">
                            <button type="submit" class="btn btn-primary">Register</button>
                        </div>
                    </div>
                </form>
                <div class="text-center mt-4">
                    <span>Already have an account?</span>
                    <a href="/login" class="link link-primary">Log in</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('next-btn').addEventListener('click', function() {
            document.getElementById('step-1').classList.remove('active');
            document.getElementById('step-2').classList.add('active');
        });
    </script>
</body>
</html>
