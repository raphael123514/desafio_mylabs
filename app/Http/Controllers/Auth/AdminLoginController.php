<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:admin');
    }

    public function Login(Request $request)
    {
        $this->validateLogin($request);

        $credentials = [
            'email' => $request->email,
            'password'=> $request->password
        ];

        $autenticado = Auth::guard('admin')->attempt($credentials, $request->remember);

        if ($autenticado) {

            return redirect()->intended(route('admin.dashboard'));
        }
        
        return redirect()->back()->withInput($request->only('email', 'remember'));
        
            
        
    }

    public function logout(Request $request)
    {
        return "amigo eu estou aqui";
        Auth::guard('admin')->logout();

        return redirect(route('admin.login'));
    }

    public function index()
    {
        return view("auth.loginAdmin");
    }

    protected function validateLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|string',
            'password' => 'required',
        ]);
    }


    
}
