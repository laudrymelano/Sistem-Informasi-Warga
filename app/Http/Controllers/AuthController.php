<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\UserWarga;
use App\Models\Warga;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function registerAkun(Request $request)
    {
        $request->validate([
            'nik' => 'required|unique:user_warga',
            'email' => 'required',
            'password' => 'required|min:6'
        ]);

        $nikWarga = Warga::where('nik', $request->nik)->first();

        if ($nikWarga != null) {
            UserWarga::create([
                'nik' => $request->nik,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            return redirect('/viewLogin')->with('success', "Akun Warga berhasil dibuat");
        } else {
            return redirect('/viewRegister')->with('error', "NIK belum terdaftar, Harap mengubungi Pengurus RT Anda");
        }
        return redirect('/viewRegister')->flash('error', "password");
    }

    public function loginWarga(Request $request)
    {
        $request->validate([
            'nik' => 'required',
            'password' => 'required'
        ]);

        if (Auth::guard('user_warga')->attempt(['nik' => $request->nik, 'password' => $request->password])) {
            return redirect()->intended('/beranda');
        }
        return redirect('/viewLogin')->with('error', "NIK atau Password Salah!");
    }

    public function loginAdmin(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'password' => 'required'
        ]);


        $credentials = $request->only('name', 'password');

        if (Auth::attempt($credentials)) {
            $akun = User::where('name', $request->name)->first();
            if ($akun->role == 'rt') {
                return redirect('/dashboardRT')->withSuccess('Login Berhasil');
            } else if ($akun->role == 'rw') {
                return redirect('/dashboardRW')->withSuccess('Login Berhasil');
            }
        }
        return redirect("/viewLoginAdmin")->with('error', 'Username atau password salah');
    }



    public function logoutAdmin()
    {
        Auth::logout();
        request()->session()->invalidate();

        return redirect("/");
    }

    public function logout()
    {
        if (Auth::guard('user_warga')->check()) {
            Auth::guard('user_warga')->logout();
            request()->session()->invalidate();
            request()->session()->regenerateToken();

            return redirect('/');
        }
        return redirect('/');
    }

    public function showForgotForm()
    {
        return view('v_forgot_password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:user_warga,email'
        ]);

        $token = \Str::random(64);
        \DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now(),
        ]);

        $action_link = route('reset.password.form', ['token' => $token, 'email' => $request->email]);
        $body = "We have received a request to reset the password for <b>SIAGA</b> account associated with " . $request->email . ". You can reset your password by clicking the link below.";

        \Mail::send('v_email_forgot', ['action_link' => $action_link, 'body' => $body], function ($message) use ($request) {
            $message->from('laudrymelano53@gmail.com', 'SIAGA');
            $message->to($request->email, 'email')
                ->subject('Reset Password');
        });

        return back()->with('success', 'We have e-mailed your password reset link');
    }

    public function showResetForm(Request $request, $token = null)
    {
        return view('v_recover_password')->with(['token' => $token, 'email' => $request->email]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:user_warga,email',
            'password' => 'required|min:5|confirmed',
            'password_confirmation' => 'required',
        ]);

        $check_token = \DB::table('password_resets')->where([
            'email' => $request->email,
            'token' => $request->token,
        ])->first();

        if (!$check_token) {
            return back()->withInput()->with('fail', 'Invalid token');
        } else {
            UserWarga::where('email', $request->email)->update([
                'password' => \Hash::make($request->password)
            ]);

            \DB::table('password_resets')->where([
                'email' => $request->email
            ])->delete();

            return redirect()->route('login')->with('success', 'Password Anda telah diperbaharui! Sekarang Anda bisa login menggunakan password baru!')->with('verifiedEmail', $request->email);
        }
    }
}
