<?php

namespace App\Http\Controllers\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserControllerClone extends Controller
{
    public function login()
    {
        return view('user.login');
    }
    
    public function authenticate(Request $request)
    {
        $user = DB::select('SELECT id FROM users WHERE nip = ?',[$request->nip]);
        // if($user == [])
        // dd("kosong");
        // dd($user);
        if($user == []){
            return redirect()->route('login');
        }

        $id = $user[0]->id; 
        
        Auth::loginUsingId($id);
        return redirect()->route('dashboard.index');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
