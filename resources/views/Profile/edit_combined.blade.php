@extends('Layout.user_dashboard')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <!-- User Information Section -->
                    <div class="space-y-4 mb-8">
                        <h2 class="text-xl font-bold">User Information</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Username -->
                            <div>
                                <strong class="text-gray-700">{{ __('Username:') }}</strong>
                                <p class="text-gray-600">{{ $user->username }}</p>
                            </div>

                            <!-- Email -->
                            <div>
                                <strong class="text-gray-700">{{ __('Email:') }}</strong>
                                <p class="text-gray-600">{{ $user->email }}</p>
                            </div>

                            <!-- Phone -->
                            <div>
                                <strong class="text-gray-700">{{ __('Phone:') }}</strong>
                                <p class="text-gray-600">{{ $user->phone }}</p>
                            </div>

                            <!-- Shop Name -->
                            <div>
                                <strong class="text-gray-700">{{ __('Store Name:') }}</strong>
                                <p class="text-gray-600">{{ $user->shop_name }}</p>
                            </div>

                            <!-- Active Date -->
                            <div>
                                <strong class="text-gray-700">{{ __('Active Date:') }}</strong>
                                <p class="text-gray-600">
                                    {{ $user->active_date ? $user->active_date->format('d-m-Y') : 'Tidak tersedia' }}
                                </p>
                            </div>

                            <!-- Days Until Active Date -->
                            <div>
                                <strong class="text-gray-700">{{ __('Inactive in:') }}</strong>
                                <p class="text-gray-600">
                                    @if($user->active_date)
                                        {{ sprintf('%02d', now()->diffInDays($user->active_date)) }} days
                                    @else
                                        Tidak tersedia
                                    @endif
                                </p>
                            </div>

                            <div>
                                <a href="/select-active-date-extend">
                                    <button class="px-4 py-2 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                        {{ __('Extend Subscription') }}
                                    </button>
                                </a>
            
                            </div>
                        </div>
                    </div>

                    <hr class="my-8 border-gray-300">

                    <!-- Form Edit Profile and Shop -->
                    <form method="POST" action="{{ route('profile.update_combined') }}">
                        @csrf
                        @method('PATCH')

                        <!-- User Profile Section -->
                        <div class="space-y-6">
                            <h2 class="text-xl font-bold mb-4">Edit Profile</h2>
                            
                            <!-- Username -->
                            <div>
                                <label for="username" class="block font-medium text-sm text-gray-700">{{ __('Username') }}</label>
                                <input id="username" type="text" name="username" value="{{ old('username', $user->username) }}" required autofocus class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:outline-none focus:border-transparent">
                                @error('username')
                                    <span class="text-red-500 text-sm mt-2">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="mt-4">
                                <label for="email" class="block font-medium text-sm text-gray-700">{{ __('Email') }}</label>
                                <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:outline-none focus:border-transparent">
                                @error('email')
                                    <span class="text-red-500 text-sm mt-2">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mt-4">
                                <a href="{{ route('profile.edit_password') }}" class="px-4 py-2 bg-gray-600 text-white font-semibold rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                                    {{ __('Change Password') }}
                                </a>
                            </div>
                        </div>

                        <hr class="my-8 border-gray-300">

                        <!-- Shop Information Section -->
                        <div class="space-y-6 mt-8">
                            <h2 class="text-xl font-bold mb-4">Edit Store Information</h2>

                            <!-- Shop Name -->
                            <div>
                                <label for="shop_name" class="block font-medium text-sm text-gray-700">{{ __('Store Name') }}</label>
                                <input id="shop_name" type="text" name="shop_name" value="{{ old('shop_name', $user->shop_name) }}" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:outline-none focus:border-transparent">
                                @error('shop_name')
                                    <span class="text-red-500 text-sm mt-2">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Address -->
                            <div>
                                <label for="address" class="block font-medium text-sm text-gray-700">{{ __('Address') }}</label>
                                <input id="address" type="text" name="address" value="{{ old('address', $user->address) }}" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:outline-none focus:border-transparent">
                                @error('address')
                                    <span class="text-red-500 text-sm mt-2">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- City -->
                            <div>
                                <label for="city" class="block font-medium text-sm text-gray-700">{{ __('City') }}</label>
                                <input id="city" type="text" name="city" value="{{ old('city', $user->city) }}" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:outline-none focus:border-transparent">
                                @error('city')
                                    <span class="text-red-500 text-sm mt-2">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Zip Code -->
                            <div>
                                <label for="zip_code" class="block font-medium text-sm text-gray-700">{{ __('Zip Code') }}</label>
                                <input id="zip_code" type="text" name="zip_code" value="{{ old('zip_code', $user->zip_code) }}" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:outline-none focus:border-transparent">
                                @error('zip_code')
                                    <span class="text-red-500 text-sm mt-2">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Phone -->
                            <div>
                                <label for="phone" class="block font-medium text-sm text-gray-700">{{ __('Phone') }}</label>
                                <input id="phone" type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:outline-none focus:border-transparent">
                                @error('phone')
                                    <span class="text-red-500 text-sm mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-8">
                            <button type="submit" class="px-4 py-2 bg-green-600 text-white font-semibold rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                {{ __('Save Changes') }}
                            </button>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
