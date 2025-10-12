<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;

class MotivasiController extends Controller
{
    function index(){
        return view('applicant.motivasi');
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'motivasi' => 'required|string|max:1000',
            'komitmen' => 'required|string|max:1000',
            'kelebihan' => 'required|string|max:1000',
            'kekurangan' => 'required|string|max:1000',
            'pengalaman' => 'required|string|max:1000',
        ], [
            'motivasi.required' => 'Motivasi is required',
            'komitmen.required' => 'Komitmen is required',
            'kelebihan.required' => 'Kelebihan is required',
            'kekurangan.required' => 'Kekurangan is required',
            'pengalaman.required' => 'Pengalaman is required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Motivasi::create([
            'motivasi' => $request->input('motivasi'),
            'komitmen' => $request->input('komitmen'),
            'kelebihan' => $request->input('kelebihan'),
            'kekurangan' => $request->input('kekurangan'),
            'pengalaman' => $request->input('pengalaman'),
        ]);

        return redirect()->route('applicant.form')->with('success', 'Motivasi berhasil disimpan');
    }
}
