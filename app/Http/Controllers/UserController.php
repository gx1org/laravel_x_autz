<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{
    public function index(): View | RedirectResponse
    {
        if (Auth::check()) {
            return redirect('/profile');
        }

        return view('index');
    }

    public function profile(): View | RedirectResponse
    {
        if (!Auth::check()) {
            return redirect('/');
        }
        $user = Auth::user();
        return view('profile', [
            'user' => $user,
        ]);
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect('/profile');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(): RedirectResponse
    {
        Auth::logout();
        return redirect('/');
    }

    public function authorize_autzorg(Request $request) : RedirectResponse {
        $auth_code = $request->auth_code;
        $app_id = env('AUTZORG_APP_ID');
        $response = Http::get("https://autz.org/api/client/$app_id/userinfo?code=$auth_code");
        if ($response->status() != 200) {
            return redirect('/')->with('error', 'Invalid code!');
        }

        $data = $response->json('user');
        $user = $this->find_autzorg_user($data);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect('/profile');
    }

    private function find_autzorg_user($userinfo) {

        $user = User::query()->where('autzorg_id', $userinfo['id'])->first();
        if ($user) {
            return $user;
        }

        $user = new User([
            'autzorg_id' => $userinfo['id'],
            'name' => $userinfo['name'],
            'email' => $userinfo['email'],
            'phone' => $userinfo['phone'],
            'address' => $userinfo['address'],
            'dob' => $userinfo['dob'],
            'gender' => $userinfo['gender'],
            'password' => 'sEcr3t'
        ]);
        $user->save();
        return $user;
    }
}
