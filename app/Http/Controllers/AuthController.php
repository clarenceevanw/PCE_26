<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class AuthController extends Controller
{
    public function googleAuth()
    {
        return Socialite::driver('google')->redirectUrl(config('services.google.redirect_admin'))->redirect();
    }

    public function applicantGoogleAuth()
    {
        return Socialite::driver('google')->redirectUrl(config('services.google.redirect_applicant'))->redirect();
    }

    public function processLogin()
    {
        $user = Socialite::driver('google')->redirectUrl(config('services.google.redirect_admin'))->stateless()->user();
        if ($user) {
            $email = strtolower($user->getEmail());
            $nrp = strtolower(explode('@', $email)[0]);
            $name = $user->getName();


            $admin = Admin::where('nrp', $nrp)->first();

            if ($admin) {
                session()->put('role', 'admin');
                session()->put('email', $email);
                session()->put('nrp', $nrp);
                session()->put('name', $name);
                session()->put('division_id', $admin->division_id);
                session()->put('division_slug', $admin->division->slug);
                return redirect()->route('admin.home')->with('login', 'Login success!');
            } else {
                return redirect()->route('admin.login')->with('invalidLogin', 'You are not registered as Battle Of Mind 2025 admin!');
            }
        }
    }

    public function applicantProcessLogin()
    {
        $user = Socialite::driver('google')->redirectUrl(config('services.google.redirect_applicant'))->stateless()->user();
        if ($user) {
            $email = strtolower($user->getEmail());
            $nrp = strtolower(explode('@', $email)[0]);
            $name = $user->getName();
            $angkatan = "20".substr($email, 3, 2);

            session()->put('email', $email);
            session()->put('nrp', $nrp);
            session()->put('name', $name);
            session()->put('angkatan', $angkatan);
            return redirect()->route('applicant.biodata')->with('login', 'Login success!');
        }
    }

    public function logout(Request $request)
    {
        if (session('role') == 'admin') {
            $request->session()->flush();
            return redirect()->route('admin.login')->with('logout', 'Logout success!');
        } else {
            $request->session()->flush();
            // Ganti user.home klo udh ad web utamany
            return redirect()->route('applicant.homepage')->with('logout', 'Logout success!');
        }
    }
}
