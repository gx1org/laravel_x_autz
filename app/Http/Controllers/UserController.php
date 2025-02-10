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

    public function authorize_kunber(Request $request) : RedirectResponse {
        $auth_code = $request->auth_code;
        $response = Http::withHeader('Authorization', env('KUNBER_APP_SECRET'))
        ->post('https://kunber.zone.id/api/client/'.env('KUNBER_APP_ID').'/exchange', [
            'code' => $auth_code
        ]);
        if ($response->status() != 200) {
            return redirect('/')->with('kunber_error', 'Invalid code!');
        }

        $data = $response->json();
        $user = $this->find_kunber_user($data);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect('/profile');
    }

    private function find_kunber_user($data) {
        $user = User::query()->where('kunber_id', $data['data']['id'])->first();
        if ($user) {
            return $user;
        }

        $user = new User([
            'kunber_id' => $data['data']['id'],
            'name' => $data['data']['name'],
            'email' => $data['data']['email'],
            'phone' => $data['data']['phone'],
            'address' => $data['data']['address'],
            'dob' => $data['data']['dob'],
            'gender' => $data['data']['gender'],
            'password' => 'random'
        ]);
        $user->save();
        return $user;
    }
}
