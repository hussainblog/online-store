<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;

class LoginController extends Controller
{

    public function index()
    {
        return view('admin.login');
    }

    public function authenticate(request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if($validator->passes())
        {
            if(Auth::guard('admin')->attempt(['email'=>$request->email, 'password'=>$request->password], $request->get('remember')))
            {
                $admin = Auth::guard('admin')->user();
                if($admin->role == 2)
                {
                    return redirect()->route('admin.dashboard');
                }
                else
                {
                    Auth::guard('admin')->logout();
                    return redirect()->route('admin.login')->with('error','You are not authorize to access admin panel.');
                }
            }
            else
            {
                return redirect()->route('admin.login')->with('error','Either Useremail/Password is Incorrect');
            }
        }
        else
        {
            return redirect()->route('admin.login')->withErrors($validator)->withInput($request->only('email'));
        }
    }
}
