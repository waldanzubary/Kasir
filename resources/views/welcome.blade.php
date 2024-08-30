<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Welcome to STARBHAK Mart</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@latest/dist/full.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .hero-bg {
            background-image: url('assets/img/hero-bg-2.png');
            background-size: cover;
            background-position: center;
        }

        .hero-waves {
            position: absolute;
            bottom: 0;
            width: 100%;
            height: auto;
        }

        .hero-waves path {
            fill: #ffffff;
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

        .animate-fadeInUp {
            animation: fadeInUp 1s ease-out forwards;
        }

        @keyframes moveWave {
        0% {
            transform: translateX(0);
        }
        50% {
            transform: translateX(-25%);
        }
        100% {
            transform: translateX(0);
        }
        }

        .wave1 {
            animation: moveWave 8s ease-in-out infinite;
            opacity: 1;
        }

        .wave2 {
            animation: moveWave 6s ease-in-out infinite;
            animation-delay: -2s;
            opacity: 0.6;
        }

        .wave3 {
            animation: moveWave 10s ease-in-out infinite;
            animation-delay: -4s;
            opacity: 0.4;
        }

    </style>
</head>

<body class="index-page bg-base-100 flex flex-col min-h-screen">
    <div class="navbar bg-yellow-400 sticky top-0 z-50 shadow-md">
        <div class="flex-1">
            <a class="btn btn-ghost normal-case text-xl" style="color: white">UMKM Cashier</a>
        </div>
        <div class="flex-none">
            @if (Route::has('login'))
                <ul class="menu menu-horizontal px-1">
                    @auth
                        <li><a href="{{ route('redirect.dashboard') }}" class="btn">Dashboard</a></li>
                    @else
                        <li><a href="{{ route('login') }}" class="btn">Log in</a></li>
                        @if (Route::has('register'))
                            <li><a href="{{ route('register') }}" class="btn btn-secondary ml-2">Register</a></li>
                        @endif
                    @endauth
                </ul>
            @endif
        </div>
    </div>

    <section id="hero" class="hero-bg relative flex flex-col items-center justify-center text-center text-white h-screen">
        <div class="container mx-auto flex flex-col justify-center items-center animate-fadeInUp">
            <h1 class="text-5xl font-bold mb-4">Welcome to UMKM Cashier!</h1>
            <p class="text-xl mb-6">Manage your UMKM store here!</p>
        </div>
        <svg class="hero-waves" xmlns="http://www.w3.org/2000/svg" viewBox="0 24 150 28" preserveAspectRatio="none">
            <defs>
                <path id="wave-path"
                    d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z"></path>
            </defs>
            <g class="wave1">
                <use href="#wave-path" x="50" y="3"></use>
            </g>
            <g class="wave2">
                <use href="#wave-path" x="50" y="0"></use>
            </g>
            <g class="wave3">
                <use href="#wave-path" x="50" y="9"></use>
            </g>
        </svg>
    </section>

    <section id="about" class="section py-20 bg-base-100">
        <div class="container mx-auto text-center">
            <h2 class="text-3xl font-bold mb-8">About UMKM Cashier</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-10">
                <div class="flex justify-center items-center">
                    <img src="{{ asset('assets/img/about.png') }}" class="rounded-lg shadow-lg w-full md:w-3/4" alt="About Us">
                </div>
                <div class="text-left space-y-4">
                    <p class="text-lg">The UMKM Cashier website is designed to streamline and simplify the financial management processes for small and medium enterprises (SMEs) and micro-businesses. This web-based application provides a comprehensive solution for managing sales transactions, inventory, and customer data in an efficient and user-friendly interface.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="features" class="section py-20 bg-base-100">
        <div class="container mx-auto text-center">
            <h2 class="text-3xl font-bold mb-8">Our Features</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-8">
                <div class="feature-card p-6 bg-white shadow-md rounded-lg hover:scale-105 transform transition duration-300">
                    <div class="icon text-primary mb-4">
                        <i class="fas fa-shopping-cart text-4xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Sales Management</h3>
                    <p class="text-gray-600">Easily record and track sales transactions, generate invoices, and manage receipts with an intuitive point-of-sale (POS) system.</p>
                </div>
                <div class="feature-card p-6 bg-white shadow-md rounded-lg hover:scale-105 transform transition duration-300">
                    <div class="icon text-primary mb-4">
                        <i class="fas fa-shipping-fast text-4xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Inventory Control</h3>
                    <p class="text-gray-600">Keep track of stock levels, manage product listings, and receive notifications for low stock to ensure optimal inventory management.</p>
                </div>
                <div class="feature-card p-6 bg-white shadow-md rounded-lg hover:scale-105 transform transition duration-300">
                    <div class="icon text-primary mb-4">
                        <i class="fas fa-tags text-4xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Reporting and Analytics</h3>
                    <p class="text-gray-600">Access insightful reports and analytics on sales performance, inventory status, and financial metrics to make informed business decisions.</p>
                </div>
                <div class="feature-card p-6 bg-white shadow-md rounded-lg hover:scale-105 transform transition duration-300">
                    <div class="icon text-primary mb-4">
                        <i class="fas fa-credit-card text-4xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">User-Friendly Interface</h3>
                    <p class="text-gray-600">Designed with simplicity in mind, the application provides a seamless user experience for both new and experienced users.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="pricing" class="section py-20 bg-base-200">
        <div class="container mx-auto text-center">
            <h2 class="text-3xl font-bold mb-8">Pricing</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="card shadow-lg bg-green-100 p-8 hover:scale-105 transform transition duration-300">
                    <h3 class="text-xl font-bold">Free Plan</h3>
                    <p class="text-gray-600 my-4">Get started with our features for free.</p>
                    <h4 class="text-4xl font-bold mb-4">Rp0,00<span class="text-lg font-normal"> only 5 days</span></h4>
                    <ul class="text-left space-y-2">
                        <li><i class="bi bi-check"></i>Get all features!</li>
                    </ul>
                </div>
                <div class="card shadow-lg bg-yellow-100 p-8 hover:scale-105 transform transition duration-300">
                    <h3 class="text-xl font-bold">Business Plan</h3>
                    <p class="text-gray-600 my-4">Ideal for try our features for your businesses.</p>
                    <h4 class="text-4xl font-bold mb-4">Rp150.000,00<span class="text-lg font-normal"> / month</span></h4>
                    <ul class="text-left space-y-2">
                        <li><i class="bi bi-check"></i>Get all features!</li>
                    </ul>
                </div>
                <div class="card shadow-lg bg-blue-100 p-8 hover:scale-105 transform transition duration-300">
                    <h3 class="text-xl font-bold">Enterprise Plan</h3>
                    <p class="text-gray-600 my-4">Perfect for large businesses that need our features!</p>
                    <h4 class="text-4xl font-bold mb-4">Rp1.200.000,00<span class="text-lg font-normal"> / year</span></h4>
                    <ul class="text-left space-y-2">
                        <li><i class="bi bi-check"></i>Get all features!</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <footer class="footer footer-center p-10 bg-base-200 text-base-content rounded">
        <div>
            <p>© 2024 UMKM Cashier. Sangat amat mantap.</p>
        </div>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.9.1/cdn.min.js"
        integrity="sha512-NCnRXyYk7ChtZwh1bJp7Gc6qX1b1Zo43RG57Et0ZZoe+ASbGk1HEN8M2ilNEBNDoTnlgBy0wJcY8PLp6ySD/kA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const navbar = document.querySelector('.navbar');
            window.addEventListener('scroll', function () {
                if (window.scrollY > 50) {
                    navbar.classList.add('visible');
                } else {
                    navbar.classList.remove('visible');
                }
            });
        });
    </script>

</body>

</html>
