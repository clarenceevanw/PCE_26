<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Applicant;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

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

        // Pastikan user punya session login
        if (!Session::has('nrp')) {
            return redirect()->route('applicant.login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $applicant = Applicant::where('nrp', session()->get('nrp'))->first();
        Log::info("applicant: " . $applicant);
        if (!$applicant) {
            Log::info("now: " . Carbon::now());
            $now = Carbon::now();
            $closeDate = Carbon::create($now->year, 11, 3, 23, 59, 59);
            Log::info("closeDate: " . $closeDate);
            if ($now->isAfter($closeDate)) {
                return redirect()->route('applicant.homepage')->with('error', 'Pendaftaran sudah tutup');
            }
        }

        if ($routeName === 'applicant.berkas') {
            if ($this->biodataMiddleware()) {
                return $next($request);
            }

            return $this->safeRedirect($request, 'Biodata belum diisi/belum disubmit');
        }

        if ($routeName === 'applicant.jadwal') {
            if ($this->biodataMiddleware() && $this->berkasMiddleware()) {
                return $next($request);
            }

            return $this->safeRedirect($request, 'Berkas belum diisi/belum disubmit');
        }

        return $next($request);
    }

    /**
     * Cek apakah biodata sudah diisi.
     */
    private function biodataMiddleware(): bool
    {
        $nrp = Session::get('nrp');

        // cache 60 detik biar gak query DB terus
        return Cache::remember("biodata_exists_$nrp", 60, function () use ($nrp) {
            return Applicant::where('nrp', $nrp)->exists();
        });
    }

    /**
     * Cek apakah berkas sudah diupload.
     */
    private function berkasMiddleware(): bool
    {
        $nrp = Session::get('nrp');

        return Cache::remember("berkas_exists_$nrp", 60, function () use ($nrp) {
            return Applicant::where('nrp', $nrp)->whereHas('applicantFile')->exists();
        });
    }

    /**
     * Redirect aman agar tidak terjadi redirect loop.
     */
    private function safeRedirect(Request $request, string $message)
    {
        // Kalau halaman sebelumnya sama dengan halaman sekarang → hindari loop
        if (url()->previous() === $request->fullUrl()) {
            return redirect()->route('applicant.homepage')->with('error', $message);
        }

        return redirect()->back()->with('error', $message);
    }
}
