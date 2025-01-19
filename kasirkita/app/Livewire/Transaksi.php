<?php

namespace App\Livewire;

use App\Models\DetailTransaksi;
use App\Models\Transaksi as ModelsTransaksi;
use Livewire\Component;
use App\Models\Produk;
use Egulias\EmailValidator\Result\Reason\DetailedReason;

class Transaksi extends Component //fungsi menampilkan form transaksi hanya jika sudah ada transaksi baru
{
    public $kode, $total, $kembalian, $total_semua_belanja;
    public $bayar = 0;
    public $transaksi_aktif;


    // fungsi TRANSAKSI hanya bisa diakses oleh kasir, selain itu tampilkan pesan error
    public function mount()
    {
        if(auth()->user()->posisi != 'kasir'){
            abort(403);
        }
    }

    public function transaksi_baru() // fungsi buat transaksi baru
    {
        $this->reset();
        $this->transaksi_aktif = new ModelsTransaksi();
        $this->transaksi_aktif->kode = 'INV/' . date('YmdHis');
        $this->transaksi_aktif->total = 0;
        $this->transaksi_aktif->status = 'pending';
        $this->transaksi_aktif->save();
    }

    public function batal_transaksi() // fungsi batalkan transaksi
    {
        if($this->transaksi_aktif)
        {
            $DetailTransaksi = DetailTransaksi::where('transaksi_id', $this->transaksi_aktif->id)->get();
            foreach($DetailTransaksi as $detail)
            {   // kembalikan jumlah stok produk ke semula jika tombol BATALKAN TRANSAKSI diklik
                $produk = Produk::find($detail->produk_id);
                $produk->stok += $detail->jumlah;
                $produk->save();
                $detail->delete();
            }
            $this->transaksi_aktif->delete();
        }
        $this->reset();
    }

    public function updatedKode() // jika kode barang diinput maka tampilkan detail produk tersebut
    {
        // cek apakah produk ada di database atau tidak berdasarkan kode produk
        $produk = Produk::where('kode', $this->kode)->first();
        if ($produk && $produk->stok > 0) // jika produk ada maka masukkan ke dalam transaksi, dan jika stok kosong maka tidak bisa input ke transaksi
        {
            $detail = DetailTransaksi::firstOrNew([
                'transaksi_id' => $this->transaksi_aktif->id,
                'produk_id' => $produk->id
            ], [
                'jumlah' => 0
            ]);
            $detail->jumlah += 1;
            $detail->save();

            $produk->stok -=1; // kurangi jumlah stok produk yg tersimpan jika produk diinput ke transaksi
            $produk->save();
            $this->reset('kode');
        }
    }

    public function render()
    {
        if($this->transaksi_aktif) // tampilkan semua transaksi yg sedang aktif
        {
            $semua_produk = DetailTransaksi::where('transaksi_id', $this->transaksi_aktif->id)->get();
            $this->total_semua_belanja = $semua_produk->sum(function ($detail) { // hitung total belanja
                return $detail->produk->harga * $detail->jumlah;
            });
        }
        else
        {
            $semua_produk = [];
        }
        return view('livewire.transaksi')->with([
            'semua_produk' => $semua_produk
        ]);
    }

    public function updatedBayar()
    {
        if($this->bayar>0){ // hitung kembalian
            $this->kembalian = $this->bayar - $this->total_semua_belanja; 
        }
    }

    public function hapus_produk($id) // fungsi hapus produk
    {
        $detail = DetailTransaksi::find($id);
        if($detail){ // kembalikan jumlah stok produk ke semula jika transaksi dihapus (tombol HAPUS diklik)
            $produk = Produk::find($detail->produk_id);
            $produk->stok += $detail->jumlah;
            $produk->save();
        }
        $detail->delete();
    }

    public function transaksi_selesai() // transaksi selesai saat tombol bayar diklik
    {
        $this->transaksi_aktif->total = $this->total_semua_belanja;
        $this->transaksi_aktif->status = 'selesai';
        $this->transaksi_aktif->save();
        $this->reset();
    }

}
