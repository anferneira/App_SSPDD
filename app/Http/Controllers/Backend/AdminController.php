<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    //
    public function login() {
        return view('admin/login.login');
    }

    public function loginInicio(Request $request) {
        /*$credenciales = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:3'
        ]);
        $credenciales['email'] = strtolower($credenciales['email']);
        if (Auth::attempt($credenciales)) {
            $request->session()->regenerate(); // 🔹 Regenera la sesión y el token CSRF
            //$redirectUrl = session('redirectAfterLogin', route('home')); // Recupera la URL original o redirige al home
            return redirect()->route('home')->with('success', 'Haz iniciado sesión.');
        }
        else {
            return redirect()->route('login')->with('error', 'Usuario y/o Contraseña incorrectos');
        }*/
        $credenciales = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:3'
        ]);
        
        $credenciales['email'] = strtolower($credenciales['email']);
    
        /*if (Auth::attempt($credenciales)) {
            $request->session()->regenerate();
    
            // Obtener la URL guardada en la sesión o redirigir a home si no hay ninguna
            $redirectUrl = session()->pull('redirectAfterLogin', route('home'));
    
            return redirect()->to($redirectUrl)->with('success', 'Haz iniciado sesión.');
        } else {
            return redirect()->route('login')->with('error', 'Usuario y/o Contraseña incorrectos');
        }*/
        if (Auth::attempt($request->only('email', 'password'))) {
            $redirectTo = session('redirectAfterLogin', route('home.home')); // Usa la última URL o el home por defecto
            session()->forget('redirectAfterLogin'); // Limpiar después de usar
    
            return redirect()->to($redirectTo)->with('success', 'Haz iniciado sesión.');
        }
        return redirect()->route('login')->with('error', 'Usuario y/o Contraseña incorrectos');
    }

    public function logout() {
        Auth::logout();
        return redirect()->route('login')->with('info', 'Sesión cerrada.');
    }

    public function home() {
        if (Auth::check()) {
            $usuario = Auth::user();
            $nombre = $usuario->name;
            $dependencia = $usuario->dependencia->nombre_d;
            $rol = $usuario->rol->nombre_r;
        }
        return view('admin/home.home', compact('usuario', 'nombre', 'rol', 'dependencia'));
    }
}
