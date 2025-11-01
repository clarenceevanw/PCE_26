<?php

namespace App\Http\Middleware;

use App\Models\Applicant;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class ApplicantMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (session()->has('nrp') && session()->has('name')) {
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
            return $next($request);
        } else {
            return redirect()->route('applicant.login')->with('guest', 'You are not logged in!');
        }
    }
}
