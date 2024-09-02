@extends('Layout.admin_dashboard')

@section('title', 'Account Details')

@section('content')
<div class="overflow-x-auto rounded-lg p-6">
    <div class="bg-white rounded-lg shadow-lg">
        <div class="p-6">
            <h1 class="text-2xl font-bold mb-4">Account Details</h1>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-gray-500 font-medium">Username:</p>
                    <p class="text-gray-700">{{ $user->username }}</p>
                </div>
                <div>
                    <p class="text-gray-500 font-medium">Email:</p>
                    <p class="text-gray-700">{{ $user->email }}</p>
                </div>
                <div>
                    <p class="text-gray-500 font-medium">Role:</p>
                    <p class="text-gray-700">{{ $user->role }}</p>
                </div>
                <div>
                    <p class="text-gray-500 font-medium">Status:</p>
                    <p class="text-gray-700 {{ $user->status == 'active' ? 'text-green-600' : 'text-red-600' }}">{{ $user->status }}</p>
                </div>
                <div>
                    <p class="text-gray-500 font-medium">Active Date:</p>
                    <p class="text-gray-700">{{ $user->active_date }}</p>
                </div>
                <div>
                    <p class="text-gray-500 font-medium">Created At:</p>
                    <p class="text-gray-700">{{ $user->created_at }}</p>
                </div>
                <div>
                    <p class="text-gray-500 font-medium">Updated At:</p>
                    <p class="text-gray-700">{{ $user->updated_at }}</p>
                </div>
            </div>
            <div class="mt-6">
                <a href="{{ route('accounts.edit', $user->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-medium py-2 px-4 rounded-lg mr-2">Edit</a>
                <form action="{{ route('accounts.destroy', $user->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-medium py-2 px-4 rounded-lg" onclick="return confirm('Are you sure you want to delete this account?')">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection