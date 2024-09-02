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
            overflow: hidden;
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
            color: #1d4ed8; /* Tailwind's blue-600 */
            margin-top: 1rem;
        }
        .description {
            font-size: 1rem;
            color: #6b7280; /* Tailwind's gray-500 */
        }
        .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: 1px solid #e5e7eb; /* Tailwind's gray-200 */
            border-radius: 8px;
            background-color: #fff; /* Put the card background white */
        }
        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            background-color: #f9fafb; /* Lighter gray for hover effect */
        }
        .btn-primary {
            background-color: #1d4ed8; /* Tailwind's blue-600 */
            color: white;
            border-radius: 9999px; /* Full round */
            padding: 0.5rem 1.5rem;
            font-size: 1rem;
            font-weight: 600;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #a0af1e; /* Darker blue */
            transform: scale(1.05);
        }
        .section-title {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: #111827; /* Tailwind's gray-900 */
            animation: fadeIn 1s ease-out;
        }
        .section-description {
            font-size: 1.125rem;
            margin-bottom: 2rem;
            color: #6b7280; /* Tailwind's gray-500 */
            animation: fadeIn 1.5s ease-out;
        }
        /* Animation Styles */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        @keyframes slideIn {
            from { transform: translateY(20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        .animate-cards {
            animation: slideIn 1s ease-out;
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
    <div class="flex-grow flex flex-col items-center justify-center p-6 animate-cards">
        <h1 class="section-title text-center animate-title">Oops! Your account is inactive!</h1>
        <p class="section-description text-center animate-description">Choose the duration for which you want to activate your account. Each option has different pricing and validity.</p>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-4xl">
            <!-- Card for 1 Month -->
            <div class="card w-full md:w-80 bg-white shadow-lg hover:bg-gray-100 transition-transform duration-300 ease-in-out transform hover:scale-105 border border-gray-200 rounded-lg">
                <div class="card-body p-6 text-center flex flex-col items-center">
                    <h2 class="card-title text-xl font-semibold text-gray-800">1 Month</h2>
                    <p class="price text-2xl font-bold text-yellow-600 mt-4">Rp150.000,00</p>
                    <div class="image-container w-full h-48 flex items-center justify-center my-4">
                        <img src="{{ asset('assets/img/diagram.png') }}" alt="Diagram" class="w-full h-full object-contain rounded-lg">
                    </div>
                    <p class="description text-gray-600 mb-4">Activate your account for 1 month.</p>
                    <form action="{{ route('setActiveDate') }}" method="POST" class="mt-4">
                        @csrf
                        <input type="hidden" name="duration" value="1_month">
                        <button type="submit" class="btn btn-warning">Select</button>
                    </form>
                </div>
            </div>

            <!-- Card for 1 Year -->
            <div class="card w-full md:w-80 bg-white shadow-lg hover:bg-gray-100 transition-transform duration-300 ease-in-out transform hover:scale-105 border border-gray-200 rounded-lg">
                <div class="card-body p-6 text-center flex flex-col items-center">
                    <h2 class="card-title text-xl font-semibold text-gray-800">1 Year</h2>
                    <p class="price text-2xl font-bold text-yellow-600 mt-4">Rp1.200.000,00</p>
                    <div class="image-container w-full h-48 flex items-center justify-center my-4">
                        <img src="{{ asset('assets/img/diagram.png') }}" alt="Diagram" class="w-full h-full object-contain rounded-lg">
                    </div>
                    <p class="description text-gray-600 mb-4">Activate your account for 1 year.</p>
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
