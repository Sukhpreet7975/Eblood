<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ForgotPasswordController extends Controller
{
    /**
     * Verify whether an email exists before showing reset options.
     */
    public function verifyEmail(Request $request): JsonResponse
    {
        $request->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'We couldn’t find an account with that email.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Email verified. You can now reset your password.',
        ]);
    }

    /**
     * Reset a user's password directly through the modal flow.
     */
    public function resetPassword(Request $request): JsonResponse
    {
        $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'We couldn’t find an account with that email.',
            ], 404);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        $request->session()->forget('login_attempts');

        return response()->json([
            'success' => true,
            'message' => 'Password updated successfully. You can now log in.',
        ]);
    }
}
