<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function getLogin()
    {
        return view('admin.auth.Login');
    }

    public function handleLogin(Request $request)
    {
        // Validation
        $request->validate([
            'email'=>'required|string|max:100',
            'password'=>'required|string|max:100'
        ]);

        // Check in DB
        $remember_me = $request->has('remember_me') ? true : false;
        if(auth()->guard('admin')->attempt(['email'=>$request->input('email'), 'password' =>$request->input('password')], $remember_me))
        {
            // notify()-> success ('تم الدخول بنجاح'));
            return redirect()->route('admin.dashboard');
        }
            // notify()-> error ('خطأ فى البيانات برجاء المحاولة مرة أخرى');
            return redirect()->back()->with(['error' => 'هناك خطأ بالبيانات']);
    }
}