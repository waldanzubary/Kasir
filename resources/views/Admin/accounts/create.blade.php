@extends('Layout.user_dashboard')

@section('title', 'Sales Transactions')

@section('content')
<div class="p-10">
    <form action="{{ route('admin.accounts.store') }}" method="POST">
        @csrf
        <div class="form-control mb-4">
            <label class="label">
                <span class="label-text">Username</span>
            </label>
            <input type="text" name="username" class="input input-bordered" required />
        </div>
        <div class="form-control mb-4">
            <label class="label">
                <span class="label-text">Email</span>
            </label>
            <input type="email" name="email" class="input input-bordered" required />
        </div>
        <div class="form-control mb-4">
            <label class="label">
                <span class="label-text">Password</span>
            </label>
            <input type="password" name="password" class="input input-bordered" required />
        </div>
        <div class="form-control mb-4">
            <label class="label">
                <span class="label-text">Confirm Password</span>
            </label>
            <input type="password" name="password_confirmation" class="input input-bordered" required />
        </div>
        <div class="form-control mb-4">
            <label class="label">
                <span class="label-text">Role</span>
            </label>
            <select name="role" class="select select-bordered" required>
                @foreach($roles as $role)
                    <option value="{{ $role }}">{{ $role }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>
@endsection
