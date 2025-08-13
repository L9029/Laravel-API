<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Maneja el inicio de sesión de un usuario y genera un token de acceso.
     *
     * Este método valida las credenciales del usuario (email y contraseña) y, si son correctas,
     * genera un token de acceso utilizando Laravel Sanctum. El token se asocia al dispositivo
     * especificado en la solicitud.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request) 
    {
        $this->validateLogin($request);

        if (Auth::attempt($request->only(['email', 'password']))) {
            return response()->json([
                'token' => $request->user()->createToken($request->device)->plainTextToken,
                'message' => 'Success',
            ]);
        }

        return response()->json([
            'message' => 'Unauthorized'
        ], 401);
    }

    /**
     * Valida los datos de la solicitud de inicio de sesión.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function validateLogin(Request $request) 
    {
        return $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device' => 'required',
        ]);
    }
}
