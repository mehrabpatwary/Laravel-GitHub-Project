<?php

namespace App\Http\Controllers;

use App\Models\AdminTable;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    function loginIndex(){
        return view('Login');
    }

    function onLogin(Request $request):int  {
        $user=$request->input('user');
        $pass=$request->input('pass');

        $countValue = AdminTable::where('username', '=', $user)->where('password', '=', $pass)->count();
        if($countValue==1){
            $request->session()->put('user', $user);
            return 1;
        }else return 0;
    }

    function onLogout(Request $request){
        $request->session()->flush();
        return redirect('/Login');
    }
}
