<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title') Kasiru</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .mber {
            font-weight: bold;
        }

        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 250px; /* Width of the sidebar */
            background-color: #f5f5f5;
            z-index: 50; /* Ensure sidebar is above other content */
            transition: transform 0.3s ease; /* Transition effect */
        }

        .sidebar-hidden {
            transform: translateX(-100%); /* Hide sidebar off-screen */
        }

        .sidebar-visible {
            transform: translateX(0); /* Show sidebar */
        }

        @media (min-width: 1024px) {
            .sidebar {
                display: block;
                transform: translateX(0); /* Sidebar always shown on large screens */
            }
        }

        @media (max-width: 1023px) {
            .mobile-navbar {
                display: flex;
            }
            .sidebar {
                position: fixed;
                top: 0;
                left: 0;
                height: 100%;
                width: 250px; /* Width of the sidebar */
                background-color: #f5f5f5;
                z-index: 50; /* Ensure sidebar is above other content */
                transform: translateX(-100%); /* Start hidden */
            }
            .sidebar-visible {
                transform: translateX(0); /* Show sidebar */
            }
        }

        /* Content Styles */
        .content {
            transition: margin-left 0.3s ease; /* Smooth transition for content */
            margin-left: 250px; /* Adjust margin to match sidebar width by default */
        }

        @media (max-width: 1023px) {
            .content {
                margin-left: 0; /* No margin on mobile screens */
                padding-left: 1rem; /* Padding to prevent content from touching screen edges */
            }
        }

        /* Navbar Styles */
        .navbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 1rem;
            background-color: #f5f5f5;
        }

        .navbar-title {
            flex: 1;
            text-align: center;
            font-weight: bold;
            padding: 0 1rem;
        }

        .profile-icon {
            margin-left: 1rem;
        }
    </style>
</head>
<body class="bg-base-100">
    <div class="flex flex-col lg:flex-row min-h-screen">
        <!-- Sidebar -->
        <div class="sidebar sidebar-hidden lg:sidebar-visible">
            <div class="p-6">
                <h1 class="text-2xl font-bold">Dashboard</h1>
                <nav class="mt-6">
                    <a href="/Warehouse" class="block hover:bg-gray-700 hover:text-white p-3 rounded">Items</a>
                    <a href="/sales/creates" class="block hover:bg-gray-700 hover:text-white p-3 rounded">Cashier</a>
                    <a href="/transaction" class="block hover:bg-gray-700 hover:text-white p-3 rounded">Transaction</a>
                </nav>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 content">
            <!-- Navbar -->
            <div class="navbar mobile-navbar">
                <div class="flex-none">
                    <!-- Hamburger Button -->
                    <button class="btn btn-square btn-ghost" onclick="toggleSidebar()">
                        <!-- Icon for hamburger menu -->
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
                <div class="navbar-title">
                    <a class="text-xl mber">Transaction</a>
                </div>
                <div class="flex-none profile-icon">
                    @if(Auth::check())
                        {{ Auth::user()->username }}
                    @endif
                    <div class="dropdown dropdown-end">
                        <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
                            <div class="w-10 rounded-full">
                                <img alt="User Avatar" src="{{ asset('Done.jpg') }}" />
                            </div>
                        </div>
                        <ul tabindex="0" class="menu menu-sm dropdown-content bg-base-300 rounded-box z-[1] mt-3 w-52 p-2 shadow">
                            <li><a href="logout">Logout</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Main Section -->
            <div class="p-4 lg:p-10">
                <main>
                    @yield('content')
                </main>
            </div>
        </div>
    </div>

    <!-- Footer -->
    

    <!-- JavaScript -->
    <script>
        function toggleSidebar() {
            const sidebar = document.querySelector('.sidebar');
            const content = document.querySelector('.content');

            if (sidebar) {
                sidebar.classList.toggle('sidebar-hidden');
                sidebar.classList.toggle('sidebar-visible');
                
                if (sidebar.classList.contains('sidebar-visible')) {
                    content.classList.add('content-padding');
                } else {
                    content.classList.remove('content-padding');
                }
            }
        }
    </script>
</body>
</html>
