<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Transaksi;

class Laporan extends Component
{
    public function render()
    {   // fungsi jika transaksi selesai (tombol bayar diklik) maka tampilkan laporan transaksi
        $semua_transaksi = Transaksi::where('status', 'selesai')->get();
        return view('livewire.laporan')->with([
            'semua_transaksi' => $semua_transaksi
        ]);
    }
}
