@extends('Layout.user_dashboard')

@section('title', 'UMKM Profile')

@section('content')
<div class="py-12 bg-gray-100 min-h-screen fade-up">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-8">
                <!-- User Information Section -->
                <div class="mb-12">
                    <h2 class="text-2xl font-bold text-gray-600 mb-6">User Information</h2>
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Label</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Value</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @php
                                $userInfo = [
                                    'Username' => $user->username,
                                    'Email' => $user->email,
                                    'Phone' => $user->phone,
                                    'Store Name' => $user->shop_name,
                                    'Active Date' => $user->active_date ? $user->active_date->toDateString() : 'Not available',
                                    'Inactive in' => $user->active_date ? sprintf('%02d days', now()->diffInDays($user->active_date)) : 'Not available',
                                ];
                            @endphp

                            @foreach ($userInfo as $label => $value)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $label }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $value }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-8 flex justify-between items-center">
                        <a href="/select-active-date-extend" class="inline-flex items-center px-4 py-2 bg-blue-500 text-white font-semibold rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition">
                            <i class="fas fa-calendar-plus mr-2"></i> Extend Subscription
                        </a>
                        <button id="logout-menu" type="button" class="inline-flex items-center px-4 py-2 bg-red-500 text-white font-semibold rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition" onclick="confirmLogout()">
                            <i class="fas fa-sign-out-alt mr-2"></i> Logout
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
                                <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                                <input id="username" type="text" name="username" value="{{ old('username', $user->username) }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-transparent sm:text-sm">
                                @error('username')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-transparent sm:text-sm">
                                @error('email')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-6">
                            <a href="{{ route('profile.edit_password') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 text-white font-semibold rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition">
                                <i class="fas fa-key mr-2"></i> Change Password
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
                            <i class="fas fa-save mr-2"></i> Save Changes
                        </button>
                    </div>
                </form>

                <!-- Subscription Information Section -->
                <div class="mt-12">
                    <h2 class="text-2xl font-bold text-gray-600 mb-6">Subscription Information</h2>
                    @if ($subscriptions->isEmpty())
                        <p class="text-gray-500">No subscriptions available.</p>
                    @else
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Duration</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Activated At</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Active Date</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($subscriptions as $subscription)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $subscription->duration }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $subscription->activated_at }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $subscription->active_date }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>

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
            title: 'Are you sure you want to logout?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, logout!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '{{ route('logout') }}';
            }
        });
    }
</script>
