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
        $wtku_mulai = "07:00";
        $wtku_selesai = "09:00";
        $tnggl_mulai = "01 Januari 2025";
        $tnggl_selesai = "03 Januari 2025";
        $desk = "Lorem ipsum dolor sit amet, consectetur adipiscing elit,
                sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. ";

        $tgl = ["1 Januari 2025", "2 Januari 2025", "3 Januari 2025"];
        $times = ["07:00 - 07:30", "07:30 - 08:00", "08:00 - 08:30", "08:30 - 09:00"];

        $hadir = ["Penjual", "Notaris"];

        return view('Jadwal.grup_UI', compact('hadir', 'nama_grup', 'durasi', 'wtku_mulai', 'wtku_selesai', 'tnggl_mulai', 'tnggl_selesai', 'desk', 'tgl', 'times'));
    }

    public function pertemuan()
    {
        $anggota = ["Penjual", "Notaris", "Pembeli"];
        return view("Jadwal.pertemuan", compact('anggota'));
    }
}
