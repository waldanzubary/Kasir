@extends('Layout.user_dashboard')

@section('title', 'Sales Transactions')

@section('content')
<!-- Begin Page Content -->
<!-- Content Row -->
<div class="container mx-auto p-6">
    <div class="flex justify-center">
        <div class="w-full max-w-lg">
            <div class="card bg-base-200 shadow-lg border border-base-300 rounded-lg">
                <div class="card-header text-xl font-semibold p-4 border-b border-base-300">Edit Account</div>
                <div class="card-body p-6">
                    <form action="{{ route('accounts.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Username -->
                        <div class="form-control mb-5">
                            <label for="username" class="label">
                                <span class="label-text font-medium">Name</span>
                            </label>
                            <input type="text" id="username" name="username" class="input input-bordered" value="{{ $user->username }}" required>
                        </div>

                        <!-- Email -->
                        <div class="form-control mb-5">
                            <label for="email" class="label">
                                <span class="label-text font-medium">Email</span>
                            </label>
                            <input type="email" id="email" name="email" class="input input-bordered" value="{{ $user->email }}" required>
                        </div>

                        <!-- Role -->
                        <div class="form-control mb-5">
                            <label for="role" class="label">
                                <span class="label-text font-medium">Role</span>
                            </label>
                            <select id="role" name="role" class="select select-bordered" required>
                                <option value="Admin" {{ $user->role == 'Admin' ? 'selected' : '' }}>Admin</option>
                                <option value="Warehouse Staff" {{ $user->role == 'Warehouse Staff' ? 'selected' : '' }}>Warehouse Staff</option>
                                <option value="User" {{ $user->role == 'User' ? 'selected' : '' }}>User</option>
                                <option value="Cashier" {{ $user->role == 'Cashier' ? 'selected' : '' }}>Cashier</option>
                            </select>
                        </div>

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
