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
</head>
<body class="bg-slate-100">
    <div class="flex flex-col lg:flex-row min-h-screen">
        <!-- Sidebar -->
        <div class="sidebar sidebar-hidden lg:sidebar-visible">
            <div class="h-full p-3 space-y-2 w-60 bg-white">
                <div class="flex items-center p-2 space-x-4">
                    <div class="w-12 h-12 rounded-full dark:bg-gray-500 flex items-center justify-center text-white">
                        <span class="text-lg font-semibold">{{ substr(Auth::user()->username, 0, 1) }}</span>
                    </div>
                    <div>
                        <a href="/profile/edit-combined">
                            <h2 class="text-lg font-semibold">{{ Auth::user()->shop_name }}</h2>
                        </a>
                        
                        <span class="flex items-center space-x-1">
                            <a rel="noopener noreferrer" href="/profile/edit-combined" class="text-xs hover:underline">{{ Auth::user()->username }}</a>
                        </span>
                    </div>
                </div>
                <div class=" ">
                    <ul class="pt-2 pb-4 space-y-1 text-sm">
                        <li class="">
                            <a rel="noopener noreferrer" href="/Warehouse" class="flex items-center p-2 space-x-3 rounded-md {{ request()->is('Warehouse') ? 'bg-blue-100' : '' }}">
                                <i class="fa-solid fa-boxes-stacked sidebar-item-icon text-xl" style="color: #c56d6d;"></i>
                                <span>Items</span>
                            </a>
                        </li>
                        <li>
                            <a rel="noopener noreferrer" href="/sales/creates" class="flex items-center p-2 space-x-3 rounded-md {{ request()->is('sales/creates') ? 'bg-blue-100' : '' }}">
                                <i class="fa-solid fa-cash-register sidebar-item-icon text-xl" style="color: #ae9ecc;"></i>
                                <span>Cashier</span>
                            </a>
                        </li>
                        <li>
                            <a rel="noopener noreferrer" href="/staff" class="flex items-center p-2 space-x-3 rounded-md {{ request()->is('staff') ? 'bg-blue-100' : '' }}">
                                <i class="fa-solid fa-chart-line sidebar-item-icon text-xl" style="color: #6bac74;"></i>
                                <span>Report</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 content">
            <!-- Navbar -->
            <nav class="bg-transparent p-5">
                <!-- Add navbar content here in the future -->
            </nav>

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
