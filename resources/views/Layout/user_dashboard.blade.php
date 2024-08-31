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
            background-color: #FFDD57; /* Yellow background for the sidebar */
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
            background-color: #f3e8a9; /* Light yellow background for hover */
        }

        .sidebar-item.active {
            background-color: #f4ffce; /* White background for active item */
            border-left: 4px solid #bebe8d; /* Blue border on the left for active item */
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
        <div class="sidebar sidebar-hidden lg:sidebar-visible flex flex-col">
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
                    <i class="fa-solid fa-boxes-stacked sidebar-item-icon text-2xl" style="color: #c56d6d;"></i>
                    <span class="sidebar-item-text">Items</span>
                </a>
                <a href="/sales/creates" class="sidebar-item {{ request()->is('sales/creates') ? 'active' : '' }}">
                    <i class="fa-solid fa-cash-register sidebar-item-icon text-2xl" style="color: #ae9ecc;"></i>
                    <span class="sidebar-item-text">Cashier</span>
                </a>
                <a href="/staff" class="sidebar-item {{ request()->is('staff') ? 'active' : '' }}">
                    <i class="fa-solid fa-chart-line sidebar-item-icon text-2xl" style="color: #6bac74;"></i>
                    <span class="sidebar-item-text">Report</span>
                </a>
                <a href="/profile/edit-combined" class="sidebar-item {{ request()->is('profile/edit-combined') ? 'active' : '' }}">
                    <i class="fa-solid fa-user sidebar-item-icon text-2xl" style="color: #8d8d8d;"></i>
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
                <button id="logout" type="button" class="inline-flex items-center px-4 py-2 bg-orange-500 text-white font-semibold rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition" onclick="confirmBack()">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
                    Back to Menu
                </button>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function toggleSidebar() {
            const sidebar = document.querySelector('.sidebar');
            sidebar.classList.toggle('sidebar-hidden');
            sidebar.classList.toggle('sidebar-visible');
        }
        function confirmBack() {
            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to back to menu?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'No, cancel!',
                confirmButtonText: 'Yes!',
                
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ route('welcome') }}";
                }
            });
        }
    </script>
</body>
</html>
