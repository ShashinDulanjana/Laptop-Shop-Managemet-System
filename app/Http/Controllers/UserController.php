<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of all registered user accounts.
     */
    public function index()
    {
        // Security check: Only allow access if the logged-in user is an admin
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    /**
     * Display the form for creating a new staff member.
     */
    public function create()
    {
        // Security check: Only allow access if the logged-in user is an admin
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        return view('admin.users.create');
    }

    /**
     * Store a newly created staff member in the database.
     */
    public function store(Request $request)
    {
        // Security check: Only admins can store new users
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        // Input validation rules
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string|in:admin,sales_assistant',
        ]);

        // Create and save the new user into the database
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Hashing password for security
            'role' => $request->role,
        ]);

        // Redirect back to dashboard with a success notification
        return redirect()->route('dashboard')->with('success', 'New Staff Member Added Successfully!');
    }

    /**
     * Remove the specified staff member from the database with Super Admin safety protection.
     */
    public function destroy($id)
    {
        // Security check: Only admins can delete users
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        // 🛡️ Super Admin Protection: Prevent the logged-in admin from deleting their own account
        if ($id == auth()->id()) {
            return redirect()->back()->with('error', 'Access Denied: You are the Super Admin. You cannot delete your own account!');
        }

        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->back()->with('success', 'User account deleted successfully.');
    }
}