@extends('Layout.user_dashboard')

@section('title', 'UMKM Profile')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Form Edit Password -->
                    <form method="POST" action="{{ route('profile.update_password') }}">
                        @csrf
                        @method('PATCH')

                        <!-- Current Password -->
                        <div>
                            <label for="current_password" class="block font-medium text-sm text-gray-700">{{ __('Password Saat Ini') }}</label>
                            <input id="current_password" type="password" name="current_password" required class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-0">
                            @error('current_password')
                                <span class="text-red-500 text-sm mt-2">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- New Password -->
                        <div class="mt-4">
                            <label for="new_password" class="block font-medium text-sm text-gray-700">{{ __('Password Baru') }}</label>
                            <input id="new_password" type="password" name="new_password" required class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-0">
                            @error('new_password')
                                <span class="text-red-500 text-sm mt-2">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Confirm New Password -->
                        <div class="mt-4">
                            <label for="new_password_confirmation" class="block font-medium text-sm text-gray-700">{{ __('Konfirmasi Password Baru') }}</label>
                            <input id="new_password_confirmation" type="password" name="new_password_confirmation" required class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-0">
                            @error('new_password_confirmation')
                                <span class="text-red-500 text-sm mt-2">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end mt-8">
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                {{ __('Simpan Password Baru') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

<style>
    input:focus {
        border-color: transparent;
        box-shadow: none;
    }
</style>
