<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\Registered;
use Auth;
use App\User;

class LoginController extends Controller
{
    public function postLogin (Request $request){
        //dd($request->all());
        if (Auth::attempt($request->only('email','password'))) {
            $user = Auth::user();
            
            $newToken = Str::random(60);

            $user->update(['api_token' => $newToken]);
                       
            return redirect('/');
        }
        return redirect('login');
    }

    public function logout (Request $request){
        Auth::logout();
        
        return redirect('login');
    }

    public function register (){
        return view('Pengguna.Register');
    }

    public function registerUser (Request $request){
        //dd($request->all());

        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);

        DB::beginTransaction();

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);

            $user->role()->attach(4);

            $user->generateActivationToken();

            event(new Registered($user));

            $user->sendEmailVerificationNotification();

            DB::commit();

            return redirect('/login')->with('toast_success', 'Silakan buka email untuk melakukan verifikasi');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect('/register')->with('toast_error', 'Gagal Register: ' . $e->getMessage());
        }
    }

    public function activateAccount($token)
    {
        $user = User::where('remember_token', $token)->first();

        if (!$user) {
            return redirect(route('login'))->with('error', 'Token aktivasi tidak valid atau akun telah aktif');
        }

        $user->email_verified_at = now();
        $user->remember_token = null;
        $user->save();

        return redirect(route('login'))->with('success', 'Akun ada telah aktif. Silakan login pada aplikasi Restoran');
    }
}
