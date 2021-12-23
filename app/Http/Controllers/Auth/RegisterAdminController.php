<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterAdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:admin');
    }

    public function index()
    {
        return view("auth.registerAdmin");
    }

    protected function validator($data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:admins'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    protected function create(Request $request)
    {
        $this->validator($request->all())->validate();

        $admin = Admin::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);
        
        $credentials = [
            'email' => $request['email'],
            'password'=> $request['password']
        ];

        $autenticado = Auth::guard('admin')->attempt($credentials, false);

        if ($autenticado) {
            return redirect(route('admin.dashboard'));

        }
        return redirect()->back()->withInput($request->only('email', 'remember'));
    }
}
