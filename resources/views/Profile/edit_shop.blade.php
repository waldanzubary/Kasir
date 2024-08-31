@extends('Layout.user_dashboard')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-xl font-bold mb-4">Edit Informasi Toko</h2>
                    <!-- Form Edit Shop -->
                    <form method="POST" action="{{ route('shop.update') }}" class="space-y-6">
                        @csrf
                        @method('PATCH')

                        <!-- Shop Name -->
                        <div>
                            <label for="shop_name" class="block font-medium text-sm text-gray-700">{{ __('Nama Toko') }}</label>
                            <input id="shop_name" type="text" name="shop_name" value="{{ old('shop_name', $user->shop_name) }}" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:outline-none focus:border-transparent">
                            @error('shop_name')
                                <span class="text-red-500 text-sm mt-2">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Address -->
                        <div>
                            <label for="address" class="block font-medium text-sm text-gray-700">{{ __('Alamat') }}</label>
                            <input id="address" type="text" name="address" value="{{ old('address', $user->address) }}" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:outline-none focus:border-transparent">
                            @error('address')
                                <span class="text-red-500 text-sm mt-2">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- City -->
                        <div>
                            <label for="city" class="block font-medium text-sm text-gray-700">{{ __('Kota') }}</label>
                            <input id="city" type="text" name="city" value="{{ old('city', $user->city) }}" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:outline-none focus:border-transparent">
                            @error('city')
                                <span class="text-red-500 text-sm mt-2">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Zip Code -->
                        <div>
                            <label for="zip_code" class="block font-medium text-sm text-gray-700">{{ __('Kode Pos') }}</label>
                            <input id="zip_code" type="text" name="zip_code" value="{{ old('zip_code', $user->zip_code) }}" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:outline-none focus:border-transparent">
                            @error('zip_code')
                                <span class="text-red-500 text-sm mt-2">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div>
                            <label for="phone" class="block font-medium text-sm text-gray-700">{{ __('Telepon') }}</label>
                            <input id="phone" type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:outline-none focus:border-transparent">
                            @error('phone')
                                <span class="text-red-500 text-sm mt-2">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="flex items-center justify-end mt-6">
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                {{ __('Simpan Informasi Toko') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
