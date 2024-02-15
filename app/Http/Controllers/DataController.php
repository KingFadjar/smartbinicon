<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Data;


class DataController extends Controller
{
    public function simpanData(Request $request)
    {
        // Validasi request jika diperlukan
        $request->validate([
            'alamat' => 'required',
            'tanggal' => 'required',
            'indikator' => 'required',
            'kapasitas' => 'required',
            'koordinat' => 'required',
        ]);

        // Simpan data ke database
        Data::create([
            'alamat' => $request->alamat,
            'tanggal' => $request->tanggal,
            'indikator' => $request->indikator,
            'kapasitas' => $request->kapasitas,
            'koordinat' => $request->koordinat,
        ]);

        // Berikan respons jika perlu
        return response()->json(['message' => 'Data berhasil disimpan']);
    }
}
