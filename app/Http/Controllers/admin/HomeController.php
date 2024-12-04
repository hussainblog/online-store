<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class HomeController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }

    public function logout(request $request)
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}
