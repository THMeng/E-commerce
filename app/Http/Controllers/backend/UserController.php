<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Sign In
    public function Signin()
    {
        return view('backend.login');
    }

    public function SigninSubmit(Request $request)
{
    $name_email = $request->name_email;
    $password   = $request->password;

    if (Auth::attempt(['name' => $name_email, 'password' => $password], $request->remember)) {
        if (Auth::user()->is_admin) {
            return redirect('/admin');
        }
        return redirect('/');
    }

    if (Auth::attempt(['email' => $name_email, 'password' => $password], $request->remember)) {
        if (Auth::user()->is_admin) {
            return redirect('/admin');
        }
        return redirect('/');
    }

    return redirect('/signin')->with('message_fail', 'Incorrect Name, Email or Password');
}

    // Sign Up
    public function Signup() {
        return view('backend.register');
    }

    public function SignupSubmit(Request $request)
    {
        if($request->file('profile')){
           $file = $request->file('profile');
           $image = $this->uploadFile($file);
        }else{
            $image = "";
        }
        $name = $request->name;
        $email = $request->email;
        $password = Hash::make($request->password);


        $check = DB::table('users')->where('name',$name)->orWhere('email',$email)->get();
        if(!count($check)!=0){
            $singup = DB::table('users')->insert([
                'name'  => $name,
                'email' => $email,
                'password' => $password,
                'profile'   =>$image,
                'created_at'    => date('Y-m-d h:i:s',strtotime('+7 hours')),
                'updated_at'    => date('Y-m-d h:i:s',strtotime('+7 hours')),
            ]);
            if($singup){
                return redirect('/signin');
            }
        
        }else{
            return redirect('/signup')->with('message','User already exist');
        }

    }

    //Logout
    public function SignOut()
    {
        Auth::logout();
        return redirect('/');
    }
}
