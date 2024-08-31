@extends('Layout.user_dashboard')

@section('content')
<div class="py-12 bg-gray-100 min-h-screen fade-up">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-8">
                <!-- Header with Logout Button -->
                <div class="flex justify-between items-center mb-8">
                    <div class="relative">
                        <!-- Optional header content -->
                    </div>
                </div>

                <!-- User Information Section -->
                <div class="mb-12">
                    <h2 class="text-2xl font-bold text-gray-600 mb-6">User Information</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @php
                            $userInfo = [
                                'Username' => $user->username,
                                'Email' => $user->email,
                                'Phone' => $user->phone,
                                'Store Name' => $user->shop_name,
                                'Active Date' => $user->active_date ? $user->active_date->format('d-m-Y') : 'Not available',
                                'Inactive in' => $user->active_date ? sprintf('%02d days', now()->diffInDays($user->active_date)) : 'Not available',
                            ];
                        @endphp

                        @foreach ($userInfo as $label => $value)
                            <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                                <h3 class="text-sm font-medium text-gray-500">{{ __($label) }}</h3>
                                <p class="mt-1 text-lg font-semibold text-gray-600">{{ $value }}</p>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-8 flex justify-between items-center">
                        <a href="/select-active-date-extend" class="inline-flex items-center px-4 py-2 bg-blue-500 text-white font-semibold rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            {{ __('Extend Subscription') }}
                        </a>
                        <button id="logout-menu" type="button" class="inline-flex items-center px-4 py-2 bg-red-500 text-white font-semibold rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition" onclick="confirmLogout()">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            Logout
                        </button>
                    </div>
                </div>

                <hr class="my-8 border-gray-200">

                <!-- Form Edit Profile and Shop -->
                <form method="POST" action="{{ route('profile.update_combined') }}" class="space-y-8">
                    @csrf
                    @method('PATCH')

                    <!-- User Profile Section -->
                    <div>
                        <h2 class="text-2xl font-bold text-gray-600 mb-6">Edit Profile</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Username -->
                            <div>
                                <label for="username" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Username') }}</label>
                                <input id="username" type="text" name="username" value="{{ old('username', $user->username) }}" required autofocus class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-transparent sm:text-sm">
                                @error('username')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Email') }}</label>
                                <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-transparent sm:text-sm">
                                @error('email')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-6">
                            <a href="{{ route('profile.edit_password') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 text-white font-semibold rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                                </svg>
                                {{ __('Change Password') }}
                            </a>
                        </div>
                    </div>

                    <hr class="my-8 border-gray-200">

                    <!-- Shop Information Section -->
                    <div>
                        <h2 class="text-2xl font-bold text-gray-600 mb-6">Edit Store Information</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @php
                                $shopFields = [
                                    'shop_name' => 'Store Name',
                                    'address' => 'Address',
                                    'city' => 'City',
                                    'zip_code' => 'Zip Code',
                                    'phone' => 'Phone',
                                ];
                            @endphp

                            @foreach ($shopFields as $field => $label)
                                <div>
                                    <label for="{{ $field }}" class="block text-sm font-medium text-gray-700 mb-1">{{ __($label) }}</label>
                                    <input id="{{ $field }}" type="text" name="{{ $field }}" value="{{ old($field, $user->$field) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-transparent sm:text-sm">
                                    @error($field)
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-8">
                        <button type="submit" class="inline-flex items-center px-6 py-3 bg-green-500 text-white font-semibold rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            {{ __('Save Changes') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

<style>
    @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-up {
            animation: fadeUp 0.6s ease-out;
        }
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmLogout() {
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to logout?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, logout!',
            cancelButtonText: 'No, cancel!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "{{ route('logout') }}";
            }
        });
    }
</script>
