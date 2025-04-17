<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function updatePassword(Request $request, User $user)
    {
        // Validate the request
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Check if the authenticated user can update the password
        if (!Auth::check() || (Auth::id() !== $user->id && Auth::user()->role !== 'admin' && Auth::user()->role !== 'super_admin')) {
            abort(403, 'Unauthorized action.');
        }

        // Update the password
        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json(['message' => 'Password updated successfully.']);
    }
}
