<?php

namespace App\Http\Controllers;

use App\Models\ActiveDateHistory;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    // Show all subscriptions for admin
    public function showAll()
    {
        // Check if user is an admin
        if (Auth::user()->role != 'Admin') {
            return redirect()->route('home')->with('error', 'Unauthorized access.');
        }

        // Retrieve all subscriptions
        $subscriptions = ActiveDateHistory::with('user')->get();

        return view('admin.subscriptions', compact('subscriptions'));
    }

    // Show subscriptions for the authenticated user
    public function showForUser()
    {
        // Retrieve subscriptions for the authenticated user
        $subscriptions = ActiveDateHistory::where('user_id', Auth::id())->get();

        return view('user.subscriptions', compact('subscriptions'));
    }
}
