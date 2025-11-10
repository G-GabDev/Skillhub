<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class GoogleAuthController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->stateless()->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();

            // Find user by email
            $user = User::where('email', $googleUser->getEmail())->first();

            if (!$user) {
                // Create new user
                $user = User::create([
                    'name' => $googleUser->getName() ?: $googleUser->getEmail(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'email_verified_at' => now(),
                    'password' => bcrypt(Str::random(16)),
                    'role' => 'freelancer',
                ]);
            } else {
                // Update google_id if missing
                if (is_null($user->google_id)) {
                    $user->google_id = $googleUser->getId();
                    $user->save();
                }
            }

            Auth::login($user);

            // Always issue a fresh token
            $user->tokens()->where('name', 'google_token')->delete();
            $token = $user->createToken('google_token')->plainTextToken;

            // Redirect to React frontend
            return redirect(env('FRONTEND_URL') . "/dashboard?token=" . urlencode($token));

        } catch (\Throwable $e) {
            return redirect("http://localhost:3000/login?error=" . urlencode($e->getMessage()));
        }
    }
}
