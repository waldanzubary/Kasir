@extends('layout.admin_dashboard')

@section('title', 'Edit Account')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-center">
        <div class="w-full max-w-md bg-white rounded-lg shadow-lg border border-gray-200">
            <div class="p-6">
                <h1 class="text-2xl font-bold mb-4">Edit Account</h1>
                <form action="{{ route('accounts.updateStatus', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    @if(Auth::user()->role == 'Admin')
                    <div class="mb-4">
                        <label for="status" class="block font-medium text-gray-700 mb-2">Status</label>
                        <select id="status" name="status" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value="active" {{ $user->status == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ $user->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                    @else
                    <div class="mb-4">
                        <label class="block font-medium text-gray-700 mb-2">Name</label>
                        <p class="text-gray-500">{{ $user->username }}</p>
                    </div>
                    <div class="mb-4">
                        <label class="block font-medium text-gray-700 mb-2">Email</label>
                        <p class="text-gray-500">{{ $user->email }}</p>
                    </div>
                    <div class="mb-4">
                        <label class="block font-medium text-gray-700 mb-2">Role</label>
                        <p class="text-gray-500">{{ $user->role }}</p>
                    </div>
                    @endif

                    <div class="flex justify-end">
                        <button type="submit" class="bg-indigo-500 hover:bg-indigo-600 text-white font-medium py-2 px-4 rounded-md">Update Account</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection