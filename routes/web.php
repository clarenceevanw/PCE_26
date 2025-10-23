<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminScheduleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ApplicantController;
use App\Http\Controllers\InterviewResultController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\ApplicantMiddleware;
use App\Http\Middleware\RegistrationFormMiddleware;

// Route::redirect('/', '/oprec');

Route::get('/', [ApplicantController::class, 'homepage'])->name('applicant.homepage');
Route::get('/register-now', [ApplicantController::class,  'registerNow'])->name('applicant.registerNow');
Route::prefix('admin')->group(function () {
    // Login and Auth Route
    Route::get('login', [AdminController::class, 'login'])->name('admin.login');
    Route::get('auth', [AuthController::class, 'googleAuth'])->name('admin.auth');
    Route::get('processLogin', [AuthController::class, 'processLogin'])->name('admin.processLogin');
    Route::middleware(AdminMiddleware::class)->group(function () {
        Route::get('/jadwalInterview', [AdminController::class, 'index'])->name('admin.home');

        //all applicant
        Route::get('/', [AdminController::class, 'allApplicantIndex'])->name('admin.allApplicant');

        //jadwal wawancara available panitia
        Route::post('/storeJadwal', [AdminScheduleController::class, 'store'])->name('admin.storeJadwal');

        //jadwal interview panitia
        Route::get('/myInterview', [AdminController::class, 'myInterviewIndex'])->name('admin.myInterview');
        Route::post('/myInterview/store', [InterviewResultController::class, 'storeHasil'])->name('admin.hasilInterview.store');

        //jadwal keseluruhan
        Route::get('/allInterview', [AdminController::class, 'allInterviewIndex'])->name('admin.allInterview');

        //tolak terima
        Route::get('/accApplicant', [AdminController::class, 'accApplicantIndex'])->name('admin.accApplicant');
        Route::post('/accApplicant/action', [AdminController::class, 'accApplicantAction'])->name('admin.accApplicant.store');

        Route::get('/detail/{applicantId}', [AdminController::class, 'applicantDetailIndex'])->name('admin.applicantDetail');

        Route::get('/export', [AdminController::class, 'exportApplicants'])->name('admin.exportApplicants');
    });
    
});
Route::prefix('applicant')->group(function () {
    Route::get('login', [ApplicantController::class, 'login'])->name('applicant.login');
    Route::get('auth', [AuthController::class, 'applicantGoogleAuth'])->name('applicant.auth');
    Route::get('processLogin', [AuthController::class, 'applicantProcessLogin'])->name('applicant.processLogin');

    Route::middleware(ApplicantMiddleware::class)->group(function () {
        Route::get('biodata', [ApplicantController::class, 'index'])->name('applicant.biodata');
        Route::post('biodata/store', [ApplicantController::class, 'storeBiodata'])->name('applicant.biodata.store');
        Route::get('berkas', [ApplicantController::class, 'berkasIndex'])->name('applicant.berkas')->middleware(RegistrationFormMiddleware::class);
        Route::post('berkas/ktm/store', [ApplicantController::class, 'storeKtm'])->name('applicant.berkas.ktm.store');
        Route::post('berkas/transkrip/store', [ApplicantController::class, 'storeTranskrip'])->name('applicant.berkas.transkrip.store');
        Route::post('berkas/bukti_kecurangan/store', [ApplicantController::class, 'storeBuktiKecurangan'])->name('applicant.berkas.bukti_kecurangan.store');
        Route::post('berkas/skkk/store', [ApplicantController::class, 'storeSkkk'])->name('applicant.berkas.skkk.store');
        Route::post('berkas/portofolio/store', [ApplicantController::class, 'storePortofolio'])->name('applicant.berkas.portofolio.store');
        Route::get('check-berkas', [ApplicantController::class, 'checkBerkas'])->name('applicant.check-berkas');
        Route::post('jadwal/store', [ApplicantController::class, 'storeJadwal'])->name('applicant.jadwal.store');
        // Route::get('jadwal', [ApplicantController::class, 'jadwalIndex'])->name('applicant.jadwal')->middleware(RegistrationFormMiddleware::class);
        Route::get('jadwal', [ApplicantController::class, 'jadwalIndex'])->name('applicant.jadwal')->middleware(RegistrationFormMiddleware::class);;

    });
});
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/admin/loginPaksaLALALA', [AuthController::class, 'loginPaksa'])->name('admin.loginPaksa');
Route::get('/applicant/loginPaksaLALALA', [AuthController::class, 'loginPaksaApplicant'])->name('applicant.loginPaksa');
Route::get('/admin/loginPaksaBPHAHAHA', [AuthController::class, 'loginPaksaBPHAHAHA'])->name('admin.loginPaksaBPHAHAHA');
