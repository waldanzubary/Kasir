<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        /* Ensure the sidebar always spans the full height */
        .sidebar {
            height: 100vh;
        }
    </style>
</head>
<body class="bg-slate-100">
    <div class="flex flex-col lg:flex-row min-h-screen h-full">
        <!-- Sidebar -->
        <div class="sidebar fixed inset-y-0 left-0 z-50 bg-white w-60 transform -translate-x-full lg:translate-x-0 lg:relative lg:flex lg:flex-col h-screen p-3 transition-transform duration-300 ease-in-out">
            <div class="flex items-center p-2 space-x-4">
                <div class="w-12 h-12 rounded-full dark:bg-gray-700 flex items-center justify-center text-white bg-gray-700">
                    <span class="text-lg font-semibold">{{ substr(Auth::user()->username, 0, 1) }}</span>
                </div>
                <div>
                    <h2 class="text-lg font-semibold">{{ Auth::user()->role }}</h2>
                    <span class="flex items-center space-x-1">
                        <a rel="noopener noreferrer" href="/profile/edit-combined-admin" class="text-xs hover:underline">{{ Auth::user()->username }}</a>
                    </span>
                </div>
            </div>
            <div class="pt-2 pb-4 space-y-1 text-sm">
                <ul class="space-y-1">
                    <li>
                        <a rel="noopener noreferrer" href="/dashboard" class="flex items-center p-2 space-x-3 rounded-md {{ request()->is('dashboard') ? 'bg-gray-200' : '' }}">
                            <i class="fa-solid fa-chart-line sidebar-item-icon text-xl" style="color: #6bac74;"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a rel="noopener noreferrer" href="/manage" class="flex items-center p-2 space-x-3 rounded-md {{ request()->is('manage') ? 'bg-gray-200' : '' }}">
                            <i class="fa-solid fa-user text-2xl" style="color: #242424;"></i>
                            <span>Manage</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1">
            <!-- AppBar (Navbar) -->
            <nav class="bg-transparent p-5 flex items-center justify-between lg:justify-start">
                <!-- Sidebar Toggle Button for Mobile -->
                <button class="lg:hidden p-2" onclick="toggleSidebar()">
                    <i class="fa-solid fa-bars text-xl"></i>
                </button>
                <!-- Add more navigation links, buttons, or logos here -->
            </nav>

            <!-- Main Section -->
            <div class="p-4 lg:p-6">
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
            sidebar.classList.toggle('-translate-x-full'); // Moves the sidebar out of view
        }

        function confirmBack() {
            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to go back to the menu?",
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
