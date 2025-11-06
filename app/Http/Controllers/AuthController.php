<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index()
    {
        $title = "Login - Aurora";
        return view("modules.auth.login", compact('title'));
    }

    public function login(Request $request)
    {
        // Validar los datos de entrada
        $credentials = $request->validate([
            'email' => 'required',
            'email',
            'password' => 'required',
        ]);

        // Buscar el usuario por correo electrónico
        $user = User::where('email', $request->email)->first();

        // Validar usuario y contraseña
        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'email' => 'Las credenciales no son correctas.'
            ])->withInput();
        }

        // Verificar si el usuario está activo
        if (!$user->active) {
            return back()->withErrors([
                'email' => 'El usuario no está activo.'
            ])->withInput();
        }

        // Crear la sesion de usuario
        Auth::login($user);
        $request->session()->regenerate();

        return to_route('home');
    }

    public function createAdminUser()
    {
        // Crear un usuario administrador por defecto
        User::create([
            'name' => 'Jhon Jimenez Admin',
            'email' => 'jhonjimenez.1257@gmail.com',
            'password' => Hash::make('123456'),
            'active' => true,
            'role' => 'admin',
        ]);
        return "Usuario administrador creado correctamente.";
    }

    public function logout()
    {
        Auth::logout();
        return to_route('login');
    }
}
