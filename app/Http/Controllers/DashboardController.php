<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Items;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function Dashboard()
{
    // Define the time frame for the current month
    $startOfMonth = Carbon::now()->startOfMonth();
    $endOfMonth = Carbon::now()->endOfMonth();

    // Fetch data for analytics
    $totalMembership = User::count();
    $totalMembershipChange = User::where('role', 'User')
                                ->where('created_at', '>', now()->subMonth())
                                ->count();

    // Account statistics
    $totalActiveUsers = User::where('status', 'active')->count(); // Assuming 'status' is the correct field
    $totalInactiveUsers = User::where('status', 'inactive')->count();
    $monthlyNewUsers = User::where('role', 'User')
                          ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                          ->count();

    return view('Admin.dashboard', compact(
        'totalMembership',
        'totalMembershipChange', 'totalActiveUsers', 'totalInactiveUsers',
        'monthlyNewUsers'
    ));
}




    public function ManageAccount()
    {
        $users = User::all();
        return view('admin.accounts.index', ['users'=> $users] );
    }

    public function ShowAccount($id)
    {
        $user = User::findOrFail($id);
        return view('admin.accounts.show', ['user' => $user]);
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.accounts.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->all());
        return redirect()->route('accounts.index')->with('success', 'Account updated successfully');
    }

    public function destroy($id)
    {
        User::destroy($id);
        return redirect()->route('accounts.index')->with('success', 'Account deleted successfully');
    }

}
