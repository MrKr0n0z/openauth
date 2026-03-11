<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    /**
     * List of allowed OAuth providers
     */
    private const ALLOWED_PROVIDERS = ['discord', 'spotify', 'twitch', 'x-twitter'];

    /**
     * Redirect to OAuth provider
     *
     * @param string $provider
     * @return \Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirect(string $provider)
    {
        // Validate provider
        if (!in_array($provider, self::ALLOWED_PROVIDERS)) {
            return redirect('/')->with('error', 'Invalid OAuth provider');
        }

        return Socialite::driver($provider)->redirect();
    }

    /**
     * Handle OAuth provider callback
     *
     * @param string $provider
     * @return \Illuminate\Http\RedirectResponse
     */
    public function callback(string $provider)
    {
        // Validate provider
        if (!in_array($provider, self::ALLOWED_PROVIDERS)) {
            return redirect('/')->with('error', 'Invalid OAuth provider');
        }

        try {
            // Get user info from provider
            $socialUser = Socialite::driver($provider)->user();

            // Find or create user
            $user = User::updateOrCreate(
                [
                    'provider' => $provider,
                    'provider_id' => $socialUser->getId(),
                ],
                [
                    'name' => $socialUser->getName() ?? $socialUser->getNickname() ?? 'Unknown',
                    'email' => $socialUser->getEmail(),
                    'avatar' => $socialUser->getAvatar(),
                    'provider_token' => $socialUser->token,
                    'provider_refresh_token' => $socialUser->refreshToken ?? null,
                ]
            );

            // Log the user in
            Auth::login($user, true);

            return redirect('/dashboard')->with('success', 'Successfully logged in!');
        } catch (\Exception $e) {
            return redirect('/')->with('error', 'Authentication failed: ' . $e->getMessage());
        }
    }

    /**
     * Logout user
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Successfully logged out!');
    }

    /**
     * Show dashboard
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function dashboard()
    {
        return view('dashboard');
    }
}
