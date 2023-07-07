<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    
    public function login(Request $request){
        $infos = $request->validate([
            'loginname' => 'required',
            'loginpassword' => 'required'
        ]);

        if (auth()->attempt(['name' => $infos['loginname'], 'password' => $infos['loginpassword']])) {

            $request->session()->regenerate();
        
        }

        return redirect('/');
    }
    
    public function logout() {
        auth()->logout();
        return redirect('/');
    }
    public function register(Request $request){
        $infos = $request->validate([
            'name' => ['required', 'min:3', Rule::unique('users','name')],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => ['required', 'min:3', 'max:20']
    ]);
        
       $infos['password'] = bcrypt($infos['password']);
       $user =User::create($infos);
       auth()-> login($user);
       return redirect('/');

    }
}
