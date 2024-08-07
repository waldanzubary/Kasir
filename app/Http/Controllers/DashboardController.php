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
        $totalRevenue = Sale::whereBetween('sale_date', [$startOfMonth, $endOfMonth])->sum('total_price');
        $totalItemsSold = Sale::join('sales_items', 'sales.id', '=', 'sales_items.sale_id')
                            ->whereBetween('sale_date', [$startOfMonth, $endOfMonth])
                            ->sum('sales_items.quantity');
        $totalMembership = User::where('role', 'user')->count();
        $totalMembershipChange = User::where('role', 'user')
                                    ->where('created_at', '>', now()->subMonth())
                                    ->count();

        // Prepare data for charts
        $monthlySales = Sale::selectRaw('DATE_FORMAT(sale_date, "%Y-%m-%d") as date, SUM(total_price) as total')
                            ->groupBy('date')
                            ->whereBetween('sale_date', [$startOfMonth, $endOfMonth])
                            ->get()
                            ->pluck('total', 'date');

        return view('Admin.dashboard', compact('totalRevenue', 'totalItemsSold', 'totalMembership', 'totalMembershipChange', 'monthlySales', 'startOfMonth', 'endOfMonth'));
    }



    public function ManageAccount()
    {
        $users = User::all();
        return view('admin.accounts.index', ['users'=> $users] );
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
