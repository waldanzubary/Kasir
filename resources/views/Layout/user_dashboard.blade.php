<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title') Kasiru</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

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
            background-color: #f5f5f5;
            z-index: 50;
            transition: transform 0.3s ease;
            width: 200px; /* Set width for the sidebar */
            padding-top: 1rem;
            padding-bottom: 1rem;
        }

        .sidebar-hidden {
            transform: translateX(-100%);
        }

        .sidebar-visible {
            transform: translateX(0);
        }

        @media (min-width: 1024px) {
            .sidebar {
                transform: translateX(0); /* Sidebar always shown on large screens */
            }
        }

        /* Content Styles */
        .content {
            transition: margin-left 0.3s ease;
            margin-left: 200px; /* Adjust margin to match sidebar width by default */
        }

        @media (max-width: 1023px) {
            .content {
                margin-left: 0; /* No margin on mobile screens */
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
        }

        .profile-icon {
            margin-left: 1rem;
        }

        /* Sidebar Item Styles */
        .sidebar-item {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            border-radius: 0.375rem;
            transition: background-color 0.3s ease;
            text-decoration: none;
            color: #757575; /* Dark color for the text */
        }

        .sidebar-item:hover {
            background-color: #eeecd3;
        }

        .sidebar-item.active {
            background-color: #e9ebbb; /* Light blue background for active item */
            border-left: 4px solid #e2e05c; /* Blue border on the left for active item */
            color: #111827; /* Dark color for the text */
        }

        .sidebar-item-icon {
            margin-right: 0.75rem;
            color: #6b7280; /* Gray color for the icon */
        }

        .sidebar-item-text {
            font-size: 0.875rem;
        }

        /* User Info Styles */
        .user-info {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 1rem;
            padding: 0 1rem;
            text-align: center;
        }

        .user-info img {
            border-radius: 50%;
            width: 60px;
            height: 60px;
            object-fit: cover;
            margin-bottom: 0.5rem;
        }

        .user-info h4 {
            margin: 0;
            font-weight: bold;
            color: #111827; /* Dark color for the text */
        }

        .user-info p {
            margin: 0;
            color: #6b7280; /* Gray color for the text */
        }

        /* Store Name Styles */
        .store-name {
            font-size: 1.25rem;
            font-weight: bold;
            color: #1f2937; /* Dark color for the text */
            text-align: center;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body class="bg-slate-100">
    <div class="flex flex-col lg:flex-row min-h-screen">
        <!-- Sidebar -->
        <div class="sidebar sidebar-hidden bg-white lg:sidebar-visible flex flex-col">
            <!-- Store Name -->
            <div class="store-name">
                UMKM Store
            </div>
            
            <!-- User Info -->
            <div class="user-info mt-10">
                <img src="{{ asset('Done.png') }}" alt="User Avatar" />
                <h4>{{ Auth::user()->shop_name }}</h4>
                <p>{{ Auth::user()->username }}</p>
            </div>
            
            <div class="flex flex-col space-y-6 mt-10">
                <a href="/Warehouse" class="sidebar-item {{ request()->is('Warehouse') ? 'active' : '' }}">
                    <i class="fa-solid fa-boxes-stacked sidebar-item-icon text-2xl" style="color: #74C0FC;"></i>
                    <span class="sidebar-item-text">Items</span>
                </a>
                <a href="/sales/creates" class="sidebar-item {{ request()->is('sales/creates') ? 'active' : '' }}">
                    <i class="fa-solid fa-cash-register sidebar-item-icon text-2xl" style="color: #63E6BE;"></i>
                    <span class="sidebar-item-text">Cashier</span>
                </a>
                <a href="/staff" class="sidebar-item {{ request()->is('staff') ? 'active' : '' }}">
                    <i class="fa-solid fa-chart-line sidebar-item-icon text-2xl" style="color: #FFD43B;"></i>
                    <span class="sidebar-item-text">Report</span>
                </a>
                <a href="/profile/edit-combined" class="sidebar-item {{ request()->is('profile/edit-combined') ? 'active' : '' }}">
                    <i class="fa-solid fa-user sidebar-item-icon text-2xl" style="color: #8f8f8f;"></i>
                    <span class="sidebar-item-text">Profile</span>
                </a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 content">
            <!-- Navbar -->
            <div class="navbar">
                <div class="flex-none">
                    <!-- Hamburger Button -->
                    <button class="btn btn-square btn-ghost sm:hidden block" onclick="toggleSidebar()">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
                <div class="navbar-title">
                    <a class="text-xl mber">Transaction</a>
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
                            <li><a href="logout">Logout</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Main Section -->
            <div>
                <main>
                    @yield('content')
                </main>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        function toggleSidebar() {
            const sidebar = document.querySelector('.sidebar');
            sidebar.classList.toggle('sidebar-hidden');
            sidebar.classList.toggle('sidebar-visible');
        }
    </script>
</body>
</html>
