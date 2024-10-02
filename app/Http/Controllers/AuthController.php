<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use App\Trait\Response\ResponseTrait;

class AuthController extends Controller
{
    use ResponseTrait;
    public function register(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8',
            ]);

            User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
            ]);

            return generateResponse('User successfully registered.', $request->all());
        } catch (\Throwable $th) {
            return generateResponse($th->getMessage(), [], 500,  'error');
        }
    }

    // Login user
    public function login(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'email' => 'required|string|email',
                'password' => 'required|string',
            ]);

            $user = User::where('email', $validatedData['email'])->first();

            if (!$user || !Hash::check($validatedData['password'], $user->password)) {
                throw ValidationException::withMessages([
                    'email' => ['The provided credentials are incorrect.'],
                ]);
            }

            // Create token
            $token = $user->createToken('auth_token')->plainTextToken;
            return generateResponse('User successfully login with token Bearer ' . $token, $request->all());
        } catch (\Throwable $th) {
            return generateResponse($th->getMessage(), [], 500,  'error');
        }
    }
    public function loginResponse()
    {
        return generateResponse('This is the login page. You are not logged in or authenticated.', [], 401, 'error');
    }

    // Logout user
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return generateResponse('Successfully logged out.');
    }
}
