<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('keyword');

        // Cari data di tabel DilJatengKorporat
        $dilJatengKorporatResults = DB::connection('pgsql')
            ->table('dil_jateng_korporat')
            ->where('nama', 'LIKE', '%' . $query . '%')
            ->select('objectid', 'target_fid', 'target_fid_1', 'tarif', 'daya', 'avg_tagihan', 'nama', 'prov', 'sbu', 'pop_dist', 'pop_id', 'pop_name', 'jarakpop', 'shape_leng', 'kabupaten', 'pop_dist_2', 'koordinat', 'x', 'y', 'idpel')
            ->get();

        // Cari data di tabel PelangganIconnet
        $pelangganIconnetResults = DB::connection('pgsql')
            ->table('pelanggan_iconnet')
            ->where('namasbu', 'LIKE', '%' . $query . '%')
            ->select('idpelanggan', 'idpln', 'namasbu', 'product', 'bandwidth', 'namakp')
            ->get();

        // Cari data di tabel PopAmarta0223
        $popAmarta0223Results = DB::connection('pgsql')
            ->table('pop_amarta_0223')
            ->where('pop_name', 'LIKE', '%' . $query . '%')
            ->select('id', 'pop_id', 'pop_name', 'lat', 'lng', 'pop_address')
            ->get();

        $results = [
            'dil_jateng_korporat' => $dilJatengKorporatResults,
            'pelanggan_iconnet' => $pelangganIconnetResults,
            'pop_amarta_0223' => $popAmarta0223Results
        ];

        // $results = [
        //     'dil_jateng_korporat' =>  $query,
        //     'pelanggan_iconnet' => 222,
        //     'pop_amarta_0223' => 333
        // ];

        return response()->json($results);
    }
}
