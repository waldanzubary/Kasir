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
        #register-form {
    max-height: 500px; /* Adjust the height as needed */
    overflow-y: auto;
    padding-right: 15px; /* Adds padding for scrollbar visibility */
    }

    /* Additional styling for form steps if needed */
    .form-step {
        display: none; /* Initially hide all steps */
    }

    .form-step.active {
        display: block; /* Display only the active step */
    }
        .form-step { display: none; }
        .form-step.active { display: block; }

        .register-card {
            display: flex;
            height: 500px; /* Set a fixed height for the card */
            border-radius: 1rem;
            overflow: hidden; /* Hide overflow for rounded corners */
            opacity: 0;
            animation: fadeIn 1s forwards; /* Fade in animation */
        }

        .left-side {
            background-color: #FDE047; /* Yellow background */
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
            animation: bounce 2s infinite; /* Bounce animation */
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
            50% { border-color: orange; }
        }
    </style>
</head>
<body class="bg-base-100 flex flex-col min-h-screen">
    <!-- Navbar -->
    <div class="navbar bg-base-100">
        <div class="flex-1">
            <a class="btn btn-ghost normal-case text-xl" href="/">UMKM Cashier</a>
        </div>
    </div>

    <!-- Register Form -->
    <div class="flex-grow flex items-center justify-center">
        <div class="register-card shadow-xl">
            <!-- Left Side -->
            <div class="left-side">
                <img src="assets/img/cashier.png" alt="Cashier" />
                <h2>Join UMKM Cashier Today!</h2>
            </div>

            <!-- Right Side -->
            <div class="right-side">
                <div class="card-body">
                    <h2 class="card-title mb-4">Register User</h2>
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
                                <button type="button" id="next-btn" class="btn btn-warning">Next</button>
                            </div>
                        </div>
                    
                        <!-- Step 2: Remaining Fields -->
                        <div class="form-step" id="step-2">
                            <h2 class="card-title mb-4 mt-4">Register Shop</h2>
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
                            <div class="form-control mt-6 mb-8">
                                <button type="submit" class="btn btn-warning">Register</button>
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
    </div>

    <script>
        document.getElementById('next-btn').addEventListener('click', function() {
            document.getElementById('step-1').classList.remove('active');
            document.getElementById('step-2').classList.add('active');
        });
    </script>
</body>
</html>
