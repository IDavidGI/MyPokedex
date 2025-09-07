<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class SimpleAuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:users,name',
            'password' => 'required|min:4',
        ]);
        $user = User::create([
            'name' => $request->name,
            'password' => Hash::make($request->password),
        ]);
        Auth::login($user);
        return redirect('/');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'password' => 'required',
        ]);
        $user = User::where('name', $request->name)->first();
        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);
            return redirect('/');
        }
        return back()->withErrors(['name' => 'Invalid credentials']);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
