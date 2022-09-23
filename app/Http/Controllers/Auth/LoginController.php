<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use function back;
use function redirect;
use function view;

class LoginController extends Controller
{
    public function show($role = null){
        if(Session::has('role')){
            return redirect(route(Session::get('role').'.home'));
        }
        if(!$role){return view('login.login');}
        return view('login.'.$role);
    }

    public function authenticate(Request $request){
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $request->validate([
            'role' => ['required'],
        ]);

        $remember = $request->input('remember');
        $role = $request->input('role');
        if ($role === 'staff' || $role === 'lecturer' || $role === 'student'){
            if (Auth::guard($role)->attempt($credentials,$remember)) {
                $request->session()->regenerate();
                $request->session()->put('role',$role);
                return redirect()->intended(route($role.'.home'));
            }

            return back()->withErrors([
                'credentials' => 'The credentials do not match our records!',
            ]);
        }
        else{
            return back()->withErrors([
                'role' => $role.' does not exist!'
            ]);
        }
    }

    public function logout(Request $request,$role)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login/'.$role);
    }
}
