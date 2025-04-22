<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function updatePassword(Request $request, User $user): \Illuminate\Http\JsonResponse
    {
        $this->validatePassword($request);

        $this->authorizePasswordUpdate($user);

        $this->updateUserPassword($user, $request->password);

        return response()->json(['message' => 'Mật khẩu đã được cập nhật thành công.']);
    }

    private function validatePassword(Request $request): void
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);
    }

    private function authorizePasswordUpdate(User $user): void
    {
        if (!Auth::check() || (Auth::id() !== $user->id && !in_array(Auth::user()->role, ['admin', 'super_admin']))) {
            abort(403, 'Hành động không được phép.');
        }
    }

    private function updateUserPassword(User $user, $password): void
    {
        $user->password = Hash::make($password);
        $user->save();
    }
}
