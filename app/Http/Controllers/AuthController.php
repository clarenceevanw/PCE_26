<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Models\Applicant;
use App\Models\Division;

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
            if (strpos($email, '@john.petra.ac.id') === false) {
                return redirect()->route('admin.login')->with('invalidLogin', 'Mohon gunakan email Petra dengan @john.petra.ac.id');
            }

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
            if (strpos($email, '@john.petra.ac.id') === false) {
                return redirect()->route('applicant.login')->with('invalidLogin', 'Mohon gunakan email Petra dengan @john.petra.ac.id');
            }
            $nrp = strtolower(explode('@', $email)[0]);
            $name = $user->getName();
            $angkatan = "20".substr($email, 3, 2);

            session()->put('email', $email);
            session()->put('nrp', $nrp);
            session()->put('name', $name);
            session()->put('angkatan', $angkatan);
            $applicant = Applicant::where('nrp', $nrp)->first();
            if (!$applicant) {
                return redirect()->route('applicant.biodata')->with('login', 'Login success!');
            }
            if ($applicant->phase == 0) {
                return redirect()->route('applicant.berkas')->with('login', 'Login success!');
            }
            if ($applicant->phase >= 1) {
                return redirect()->route('applicant.jadwal')->with('login', 'Login success!');
            }
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

    public function loginPaksaApplicant()
    {
        session()->put('email', "c14240155@john.petra.ac.id");
        session()->put('nrp', 'c14240155');
        session()->put('name', "DUMMY BOLO");
        $angkatan = "20".substr('C14240155', 3, 2);
        session()->put('angkatan', $angkatan);
        return redirect()->route('applicant.biodata')->with('login', 'Login success!');
    }

    public function loginPaksa()
    {
        session()->put('role', 'admin');
        session()->put('email', 'C14240500@gmail.com');
        session()->put('nrp', 'C14240500');
        session()->put('name', "DUMMY BOLO");
        $div = Division::where('slug', 'sekkonkes')->first();
        session()->put('division_id', $div->id);
        session()->put('division_slug', $div->slug);

        return redirect()->route('admin.home')->with('login', 'Login success!');
    }

    public function loginPaksaBPHAHAHA()
    {
        session()->put('role', 'admin');
        session()->put('email', 'C14240580@gmail.com');
        session()->put('nrp', 'C14240580');
        session()->put('name', "DUMMY BOLO");
        $div = Division::where('slug', 'bph')->first();
        session()->put('division_id', $div->id);
        session()->put('division_slug', $div->slug);

        return redirect()->route('admin.home')->with('login', 'Login success!');
    }
}
