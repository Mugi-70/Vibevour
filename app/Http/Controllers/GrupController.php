<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GrupController extends Controller
{
    //
    public function index()
    {

        //? cari period dari rentang tanggal
        //? cari period dari jam (sesuai dengan durasi)

        $nama_grup = "Jual-Beli";
        $durasi = "30 menit";
        $wtku = "07:00 s.d. 09:00";
        $tnggl = "01 Januari 2025 s.d. 03 Januari 2025";
        $desk = "Lorem ipsum dolor sit amet, consectetur adipiscing elit,
        sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
        quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.";

        $tgl = ["01-01-2025", "02-01-2025", "03-01-2025"];
        $times = ["08:00", "08:30", "09:00"];

        return view('Jadwal.grup_UI', compact('nama_grup', 'durasi', 'wtku', 'tnggl', 'desk', 'tgl', 'times'));
    }
}
