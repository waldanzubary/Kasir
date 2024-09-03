<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@latest/dist/full.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        #register-form {
            max-height: 500px;
            overflow-y: auto;
            padding-right: 15px;
        }

        .form-step {
            display: none;
        }

        .form-step.active {
            display: block;
        }

        .register-card {
            display: flex;
            flex-direction: column;
            min-height: 500px;
            border-radius: 1rem;
            overflow: hidden;
            opacity: 0;
            animation: fadeIn 1s forwards;
        }

        .left-side {
            background-color: rgb(75, 80, 77);
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            text-align: center;
            transform: translateY(-20px);
            animation: slideIn 1s forwards;
        }

        .left-side img {
            max-width: 80%;
            height: auto;
            margin-bottom: 1rem;
            animation: bounce 2s infinite;
        }

        .left-side h2 {
            font-size: 1.2rem;
            font-family: monospace;
            white-space: nowrap;
            overflow: hidden;
            border-right: .15em solid orange;
            animation: typing 3.5s steps(40, end), blink-caret .75s step-end infinite;
        }

        .right-side {
            flex: 1;
            background-color: #ffffff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 2rem;
        }

        @keyframes fadeIn {
            to { opacity: 1; }
        }

        @keyframes slideIn {
            to { transform: translateY(0); }
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
            40% { transform: translateY(-30px); }
            60% { transform: translateY(-15px); }
        }

        @keyframes typing {
            from { width: 0; }
            to { width: 100%; }
        }

        @keyframes blink-caret {
            from, to { border-color: transparent; }
            50% { border-color: orange; }
        }

        @media (min-width: 768px) {
            .register-card {
                flex-direction: row;
                height: 500px;
            }

            .left-side {
                transform: translateX(-20px);
            }

            @keyframes slideIn {
                to { transform: translateX(0); }
            }
        }
    </style>
</head>
<body class="bg-base-100 flex flex-col min-h-screen">
    <div class="flex-grow flex items-center justify-center p-4">
        <div class="register-card shadow-xl w-full max-w-4xl">
            <div class="left-side">
                <img src="assets/img/cashier.png" alt="Cashier" />
                <h2 style="color: white">Join UMKM Cashier Today!</h2>
            </div>
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
                                <button type="button" id="next-btn" class="btn" style="background-color: rgb(75, 80, 77); color: white">Next</button>
                            </div>
                        </div>
                    
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
                                <textarea id="address" name="address" class="textarea textarea-bordered" required></textarea>
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
                                <button type="submit" class="btn" style="background-color: rgb(75, 80, 77); color: white">Register</button>
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