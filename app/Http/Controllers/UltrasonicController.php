<?php

    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use App\Models\Ultrasonic;

    class UltrasonicController extends Controller
    {
        /**
         * Menampilkan daftar data ultrasonic.
         */

         public function index()
        {
            $ultrasonicData = Ultrasonic::getUltrasonicDataArray();

            //dd($ultrasonicData); // Tambahkan dd() untuk memeriksa tipe data sebenarnya

            return view('get-rute', ['ultrasonics' => $ultrasonicData]);
        }


        /**
         * Menampilkan formulir untuk membuat data ultrasonic baru.
         */
        public function create()
        {
            return view('ultrasonic.create');
        }

        /**
         * Menyimpan data ultrasonic baru.
         */
        public function store(Request $request)
        {
            Ultrasonic::create($this->validateUltrasonicData($request));

            return redirect()->route('ultrasonic.index')->with('success', 'Data Ultrasonic berhasil ditambahkan!');
        }

        /**
         * Menampilkan data ultrasonic tertentu.
         */
        public function show($id)
        {
            $ultrasonic = Ultrasonic::findOrFail($id);
            return view('ultrasonic.show', compact('ultrasonic'));
        }

        /**
         * Validasi data ultrasonic.
         */
        protected function validateUltrasonicData(Request $request)
        {
            return $request->validate([
                'lat' => 'required|numeric',
                'lng' => 'required|numeric',
                'kosong' => 'required|numeric',
                'setengah' => 'required|numeric',
                'penuh' => 'required|numeric',
                'kapasitas_sampah' => 'required|numeric',
                'kapasitas_mobil' => 'required|numeric',
                'status' => 'required|numeric',
            ]);
        }
    }
