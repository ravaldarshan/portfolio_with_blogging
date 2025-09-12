<?php

namespace App\Http\Controllers\admin;

use App\Models\admin\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
                    'message' => 'Email not registered',
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
                    'message' => 'Email not found!',
                    'valid' => false
                ]);
            }
             return response()->json([
                    'valid' => true
                ]);
    
            if (Hash::check($request->password, $user->password)) {
                return response()->json([
                    'valid' => true
                ]);
            } else {
                return response()->json([
                    'message' => 'Password is incorrect!',
                    'valid' => false
                ]);
            }
        }
    }
    
    public function loginProses(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|min:8|max:255',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('admin.login')->with('error', 'Incorrect email or password.');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('admin.login')->with('success', 'Succeed Logout.'); 
    }
}
