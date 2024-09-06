<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>UMKM Subscription</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@latest/dist/full.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
            background-attachment: fixed;
        }
        .background-pattern {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('https://www.transparenttextures.com/patterns/diagonal-stripes.png');
            opacity: 0.1;
            z-index: -1;
        }
        .card-body {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
        }
        .card-title {
            font-size: 1.25rem;
            font-weight: 600;
        }
        .price {
            font-size: 1.5rem;
            font-weight: 700;
            color: #f59e0b; /* Tailwind's yellow-600 */
            margin-top: 1rem;
        }
        .description {
            font-size: 1rem;
            color: #6b7280; /* Tailwind's gray-500 */
        }
        .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }
        .btn-primary {
            background-color: #f59e0b; /* Tailwind's yellow-600 */
            color: white;
            border-radius: 9999px; /* Full round */
            padding: 0.5rem 1.5rem;
            font-size: 1rem;
            font-weight: 600;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #d97706; /* Darker yellow */
            transform: scale(1.05);
        }
        .section-title {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: #111827; /* Tailwind's gray-900 */
        }
        .section-description {
            font-size: 1.125rem;
            margin-bottom: 2rem;
            color: #6b7280; /* Tailwind's gray-500 */
        }
        .image-container {
            width: 100%;
            height: 150px;
            margin: 1rem 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .image-container img {
            max-height: 100%;
            max-width: 100%;
            object-fit: contain;
        }

        /* Highlighted card border color and animation */
        .card-highlight {
            background-color: rgb(255, 255, 228);
            border-color: #f59e0b; /* Tailwind's yellow-600 */
            animation: highlightAnimation 1.5s infinite;
        }

        /* Keyframes for the animation */
        @keyframes highlightAnimation {
            0%, 100% {
                transform: scale(1);
                box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            }
            50% {
                transform: scale(1.05);
                box-shadow: 0 12px 24px rgba(0, 0, 0, 0.3);
            }
        }

        /* Ensure hover effect doesn't conflict with animation */
        .card-highlight:hover {
            animation: none;
            transform: scale(1.05);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body class="flex flex-col min-h-screen relative overflow-hidden">
    <!-- Background Pattern -->
    <div class="background-pattern"></div>

    <!-- Navbar -->
    <div class="navbar">
        <div class="flex-1">
            <a class="btn btn-ghost normal-case text-xl" href="/"></a>
        </div>
        <div class="flex-none profile-icon gap-2">
            @if(Auth::check())
                {{ Auth::user()->username }}
            @endif
            <div class="dropdown dropdown-end">
                <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
                    <div class="w-10 rounded-full">
                        <img alt="User Avatar" src="{{ asset('Done.png') }}" />
                    </div>
                </div>
                <ul tabindex="0" class="menu menu-sm dropdown-content bg-base-300 rounded-box z-[1] mt-3 w-52 p-2 shadow">
                    <li><a href="{{ route('logout') }}">Logout</a></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Active Date Selection -->
    <div class="flex-grow flex flex-col items-center justify-center p-6">
        <h1 class="section-title">Select Your Account Activation Duration</h1>
        <p class="section-description">Choose the duration for which you want to activate your account. Each option has different pricing and validity.</p>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Card for 5 Days (Highlighted) -->
            <div class="card w-64 bg-white shadow-lg hover:bg-gray-100 transition-transform duration-300 ease-in-out transform hover:scale-105 border border-gray-200 rounded-lg card-highlight">
                <div class="card-body p-6 text-center flex flex-col items-center">
                    <h1 class="card-title">5 Days Trial</h1>
                    <div class="image-container">
                        <img src="{{ asset('assets/img/diagram.png') }}" alt="Free Trial">
                    </div>
                    <p class="price">FREE</p>
                    <p class="description">Activate your account for 5 days for free!</p>
                    <form action="{{ route('setActiveDate') }}" method="POST" class="mt-4">
                        @csrf
                        <input type="hidden" name="duration" value="5_days">
                        <button type="submit" class="btn btn-warning">Select</button>
                    </form>
                </div>
            </div>
            
            <!-- Card for 1 Month -->
            <div class="card w-64 bg-white shadow-lg hover:bg-gray-100 transition-transform duration-300 ease-in-out transform hover:scale-105 border border-gray-200 rounded-lg">
                <div class="card-body p-6 text-center flex flex-col items-center">
                    <h2 class="card-title">1 Month</h2>
                    <div class="image-container">
                        <img src="{{ asset('assets/img/diagram.png') }}" alt="1 Month">
                    </div>
                    <p class="price">Rp150.000,00</p>
                    <p class="description">Activate your account for 1 month.</p>
                    <form action="{{ route('setActiveDate') }}" method="POST" class="mt-4">
                        @csrf
                        <input type="hidden" name="duration" value="1_month">
                        <button type="submit" class="btn btn-warning">Select</button>
                    </form>
                </div>
            </div>

            <!-- Card for 1 Year -->
            <div class="card w-64 bg-white shadow-lg hover:bg-gray-100 transition-transform duration-300 ease-in-out transform hover:scale-105 border border-gray-200 rounded-lg">
                <div class="card-body p-6 text-center flex flex-col items-center">
                    <h2 class="card-title">1 Year</h2>
                    <div class="image-container">
                        <img src="{{ asset('assets/img/diagram.png') }}" alt="1 Year">
                    </div>
                    <p class="price">Rp1.200.000,00</p>
                    <p class="description">Activate your account for 1 year.</p>
                    <form action="{{ route('setActiveDate') }}" method="POST" class="mt-4">
                        @csrf
                        <input type="hidden" name="duration" value="1_year">
                        <button type="submit" class="btn btn-warning">Select</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
