<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Select Active Date Duration</title>
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
            color: #1d4ed8; /* Tailwind's blue-600 */
        }
        .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .card-highlight {
            border: 4px solid #1d4ed8; /* Tailwind's blue-600 */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            z-index: 10; /* Ensure it appears above other cards */
            transform: scale(1.1); /* Slightly larger scale for emphasis */
        }
        .btn-primary {
            transition: background-color 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #1d4ed8; /* Tailwind's blue-600 */
            color: white;
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
    </style>
</head>
<body class="flex flex-col min-h-screen relative overflow-hidden">
    <!-- Background Pattern -->
    <div class="background-pattern"></div>

    <!-- Navbar -->
    <div class="navbar bg-base-100">
        <div class="flex-1">
            <a class="btn btn-ghost normal-case text-xl" href="/">STARBHAK Mart</a>
        </div>
    </div>

    <!-- Active Date Selection -->
    <div class="flex-grow flex flex-col items-center justify-center p-6">
        <h1 class="section-title">Satisfied with our service? Extend your Subscription!</h1>
        <p class="section-description">Choose the duration for which you want to activate your account. Each option has different pricing and validity.</p>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Card for 5 Days (Highlighted) -->
            
            <!-- Card for 1 Month -->
            <div class="card w-64 bg-base-200 shadow-xl hover:bg-base-300">
                <div class="card-body">
                    <h2 class="card-title">1 Month</h2>
                    <p class="price">Rp150.000,00</p>
                    <p>Activate your account for 1 month.</p>
                    <form action="{{ route('setActiveDate') }}" method="POST" class="mt-4">
                        @csrf
                        <input type="hidden" name="duration" value="1_month">
                        <button type="submit" class="btn btn-primary">Select</button>
                    </form>
                </div>
            </div>

            <!-- Card for 1 Year -->
            <div class="card w-64 bg-base-200 shadow-xl hover:bg-base-300">
                <div class="card-body">
                    <h2 class="card-title">1 Year</h2>
                    <p class="price">Rp1.200.000,00</p>
                    <p>Activate your account for 1 year.</p>
                    <form action="{{ route('setActiveDate') }}" method="POST" class="mt-4">
                        @csrf
                        <input type="hidden" name="duration" value="1_year">
                        <button type="submit" class="btn btn-primary">Select</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
