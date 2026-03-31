<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validator->errors()], 400);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'access_token' => $token,
            'token_type' => 'Bearer',
        ], 201);
    }
    //Copia seguridad login sin cookies y cambios
    /*
    - Caso fallar solo quitar lo no comentado y poner este
    - quitar el contenido de bootstrap/app.php
    - quitar el contenido de .env
    - quitar el contenido de auth-bridge.js
    */
    /*public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => '¡Login exitoso!',
                'access_token' => $token,
                'user' => $user
            ], 200);
        }

        return response()->json([
            'message' => 'Credenciales incorrectas. Revisa tu email o contraseña.'
        ], 401);
    }*/
    
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return response()->json([
                'message' => '¡Login exitoso!',
                'user' => Auth::user()
            ]);
        }

        return response()->json(['message' => 'Credenciales incorrectas.'], 401);
    }
}
