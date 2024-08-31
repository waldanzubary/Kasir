@extends('Layout.admin_dashboard')

@section('title', 'Sales Transactions')

@section('content')
<div class="container mx-auto p-6">
    <div class="flex justify-center">
        <div class="w-full max-w-lg">
            <div class="card bg-base-200 shadow-lg border border-base-300 rounded-lg">
                <div class="card-header text-xl font-semibold p-4 border-b border-base-300">Edit Account</div>
                <div class="card-body p-6">
                    <form action="{{ route('accounts.updateStatus', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Hanya Tampilkan Form Status Jika Admin -->
                        @if(Auth::user()->role == 'Admin')
                        <div class="form-control mb-5">
                            <label for="status" class="label">
                                <span class="label-text font-medium">Status</span>
                            </label>
                            <select id="status" name="status" class="select select-bordered">
                                <option value="active" {{ $user->status == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ $user->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                        @else
                        <!-- Menampilkan data lain tanpa input field jika bukan admin -->
                        <div class="form-control mb-5">
                            <label class="label">
                                <span class="label-text font-medium">Name</span>
                            </label>
                            <p class="text-gray-500">{{ $user->username }}</p>
                        </div>
                        <div class="form-control mb-5">
                            <label class="label">
                                <span class="label-text font-medium">Email</span>
                            </label>
                            <p class="text-gray-500">{{ $user->email }}</p>
                        </div>
                        <div class="form-control mb-5">
                            <label class="label">
                                <span class="label-text font-medium">Role</span>
                            </label>
                            <p class="text-gray-500">{{ $user->role }}</p>
                        </div>
                        @endif

                        <div class="flex justify-end">
                            <button type="submit" class="btn btn-primary">Update Account</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
