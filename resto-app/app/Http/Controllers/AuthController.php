<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        try {
            $response = Http::post('http://localhost:9090/api/auth/login', [
                'email' => $request->email,
                'password' => $request->password,
            ]);

            $responseData = $response->json();

            if (isset($responseData['status']) && $responseData['status'] === true) {
                $data = $responseData['data'];

                $token = $data['token'];
                // Simpan token ke session atau cookies
                session()->put('token', $token);

                if ($data['role'] === 'admin') {
                    return redirect()->route('admin.dashboard');
                } else {
                    return redirect()->route('customer.dashboard');
                }
            } else {
                return back()->withErrors(['login' => 'Invalid credentials']);
            }
        } catch (\Exception $e) {
            // Menangani kesalahan jika respons tidak aktif atau gagal
            \Log::error('Failed to login: ' . $e->getMessage());
            return back()->withErrors(['login' => 'Failed to login. Please try again later.']);
        }
    }






    public function showRegistrationForm()
{
    return view('auth.register');
}

public function register(Request $request)
{
    try {
        $response = Http::post('http://localhost:9090/api/auth/register', [
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        if ($response->status() === 201) {
            return redirect()->route('login')->with('success', 'Registration successful, please login.');
        } else {
            return back()->withErrors(['register' => 'Registration failed.'])->withInput();
        }
    } catch (\Illuminate\Http\Client\ConnectionException $e) {
        // Handle the case when connection to the endpoint fails
        return back()->withErrors(['register' => 'Failed to connect to the registration service. Please try again later.'])->withInput();
    }
}
public function logout()
{
    try {
        // Hapus token dari session atau cookies
        session()->forget('token');

        return redirect()->route('login')->with('success', 'Logged out successfully.');
    } catch (\Exception $e) {
        // Handle the case when logout fails
        return back()->withErrors(['logout' => 'Failed to logout.'])->withInput();
    }
}



}