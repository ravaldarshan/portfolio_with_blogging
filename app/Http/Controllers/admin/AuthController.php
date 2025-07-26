<?php

namespace App\Http\Controllers\admin;

use App\Models\admin\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(){
        return view('administrator.authentication.login');
    }

    public function checkEmail(Request $request){
        if($request->ajax()){
            $data = User::where('email', $request->email);
    
            if(empty($data)){
                return response()->json([
                    'message' => 'Email tidak terdaftar',
                    'valid' => false
                ]);
            } else {
                return response()->json([
                    'valid' => true
                ]);
            }
        }
    }
    
    public function checkPassword(Request $request) {
        if ($request->ajax()) {
            $user = User::where('email', $request->email)->first();
    
            if (!$user) {
                return response()->json([
                    'message' => 'Email tidak ditemukan',
                    'valid' => false
                ]);
            }
    
            if (Hash::check($request->password, $user->password)) {
                return response()->json([
                    'valid' => true
                ]);
            } else {
                return response()->json([
                    'message' => 'Password tidak sesuai',
                    'valid' => false
                ]);
            }
        }
    }
    
    public function loginProses(Request $request)
    {
        // $validator = Validator::make($request->all(), [
        //     'email' => 'required|string|email|max:255',
        //     'password' => 'required|min:8|max:255',
        // ]);

        // if ($validator->fails()) {
        //     // return response()->json([
        //     //     'status' => 'error',
        //     //     'message' => 'Validator tidak valid',
        //     // ],422);
        //     return back()->withErrors($validator)->withInput();
        // }
        // dd($request->email,$request->password);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Jika autentikasi berhasil, alihkan ke halaman yang sesuai
            return redirect()->route('admin.dashboard');
        }

        // Jika autentikasi gagal, alihkan kembali ke halaman masuk dengan pesan error
        return redirect()->route('admin.login')->with('error', 'Email atau password salah.');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('admin.login')->with('success', 'Berhasil Logout.'); // Ganti 'login' dengan rute halaman masuk yang sesuai
    }
}
