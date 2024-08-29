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
        .sidebar-hidden {
            transform: translateX(-100%);
        }
        .sidebar-show {
            transform: translateX(0);
        }
        .transition-transform {
            transition: transform 0.3s ease-in-out;
        }
    </style>
</head>
<body class="bg-base-100">
    <div class="flex">
        <!-- Sidebar -->
        <div id="sidebar" class="w-64 bg-base-200 min-h-screen shadow-lg transition-transform">
            <div class="p-6">
                <!-- Profile Information -->
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 rounded-full overflow-hidden">
                        <img src="{{ asset('Done.jpg') }}" alt="User Avatar" class="w-full h-full object-cover" />
                    </div>
                    <div class="ml-4">
                        <p class="text-lg font-semibold">@if(Auth::check()) {{ Auth::user()->username }} @endif</p>
                        <p class="text-sm text-gray-500">User Role</p>
                    </div>
                </div>
                <h1 class="text-2xl font-bold">Dashboard</h1>
                <nav class="mt-6">
                    <a href="/dashboard" class="block hover:bg-gray-700 hover:text-white p-3 rounded flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" class="fill-current mr-2">
                            <path d="M12 3v9.27c-.59.1-1.16.22-1.72.39L7 10.97v2.53c0 .55.45 1 1 1h4v1h-3c-.55 0-1-.45-1-1v-2.5c0-.2.04-.39.1-.57l1.8-1.8c.45-.45 1.05-.72 1.7-.72h2.5c1.26 0 2.29 1.04 2.29 2.29v1.59c.47.22.9.49 1.29.81V9c0-1.1-.9-2-2-2h-1.07c-.45 0-.88-.23-1.13-.6L12 3zm-3 15v-2h2v2h2v-2h2v-2h-2v-2h-2v2H7v2H5v2h2v2h2zm5-4v-2h-2v2h2z"></path>
                        </svg>
                        Home
                    </a>
                    <a href="/manage" class="block hover:bg-gray-700 hover:text-white p-3 rounded flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" class="fill-current mr-2">
                            <path d="M12 1.5C6.48 1.5 2 6.03 2 11.5s4.48 10 10 10 10-4.53 10-10S17.52 1.5 12 1.5zM12 19c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zM13 10h-2V7h2v3zm-2 4h2v-2h-2v2z"></path>
                        </svg>
                        Account Manage
                    </a>
                </nav>
                <button id="toggleSidebar" class="btn btn-ghost mt-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" class="fill-current">
                        <path d="M3 12l18 0M3 6l18 0M3 18l18 0"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1">
            <div class="navbar bg-base-100">
                <div class="flex-1">
                    <a class="btn btn-ghost text-xl mber">Starbhak MART Transaction</a>
                </div>
                <div class="flex-none gap-2">
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

            <div class="p-10">
                <main>
                    @yield('content')
                </main>
            </div>
        </div>
    </div>

    <footer class="footer bg-base-300 text-base-content p-10">
        <nav>
            <h6 class="footer-title">Services</h6>
            <a href="https://github.com/waldanzubary" class="link link-hover">Branding</a>
            <a href="https://github.com/waldanzubary" class="link link-hover">Design</a>
            <a href="https://github.com/waldanzubary" class="link link-hover">Marketing</a>
            <a href="https://github.com/waldanzubary" class="link link-hover">Advertisement</a>
        </nav>
        <nav>
            <h6 class="footer-title">Starbhak Mart Corporation</h6>
            <a href="https://github.com/waldanzubary" class="link link-hover">About us</a>
            <a href="https://github.com/waldanzubary" class="link link-hover">Contact</a>
            <a href="https://github.com/waldanzubary" class="link link-hover">Jobs</a>
            <a href="https://github.com/waldanzubary" class="link link-hover">Press kit</a>
        </nav>
        <nav>
            <h6 class="footer-title">Social</h6>
            <div class="grid grid-flow-col gap-4">
                <a href="https://twitter.com/yourprofile">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="fill-current">
                        <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"></path>
                    </svg>
                </a>
                <a href="https://youtube.com/yourchannel">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="fill-current">
                        <path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"></path>
                    </svg>
                </a>
                <a href="https://facebook.com/yourprofile">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="fill-current">
                        <path d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z"></path>
                    </svg>
                </a>
            </div>
        </nav>
    </footer>

    <script>
        document.getElementById('toggleSidebar').addEventListener('click', function () {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('sidebar-hidden');
            sidebar.classList.toggle('sidebar-show');
        });
    </script>
</body>
</html>
