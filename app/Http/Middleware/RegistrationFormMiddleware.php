<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Applicant;
use Illuminate\Support\Facades\Session;

class RegistrationFormMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $routeName = $request->route()->getName();

        if($routeName === 'applicant.berkas'){
            if($this->biodataMiddleware($request) && $this->motivasiMiddleware($request)){
                return $next($request);
            }else{
                return redirect()->route('applicant.motivasi')->with('error', 'Kompetensi dan Komitmen Pribadi belum diisi/belum disubmit');
            }
        }
        elseif($routeName === 'applicant.jadwal'){
            if($this->berkasMiddleware($request)){
                return $next($request);
            }else{
                return redirect()->route('applicant.berkas')->with('error', 'Berkas belum diisi/belum disubmit');
            }
        }
    }

    private function biodataMiddleware(Request $request)
    {
        $nrp = Session::get('nrp');
        $isExists = Applicant::where('nrp', $nrp)->exists();
        return $isExists;
    }

    private function motivasiMiddleware(Request $request)
    {
        $nrp = Session::get('nrp');
        $isExists = Applicant::where('nrp', $nrp)->whereHas('motivation')->exists();
        return $isExists;
    }

    private function berkasMiddleware(Request $request)
    {
        $nrp = Session::get('nrp');
        $isExists = Applicant::where('nrp', $nrp)->whereHas('applicantFile')->exists();
        return $isExists;
    }
}
