<?php

namespace App\Livewire;

use App\Models\Produk as ModelProduk;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\Produk as ImportProduk;

class Produk extends Component
{   // fungsi-fungsi
    use WithFileUploads;
    public $pilihan_menu = 'lihat';
    public $kode;
    public $nama;
    public $harga;
    public $stok;
    public $produk_terpilih;
    public $file_excel;

    // fungsi PRODUK hanya bisa diakses oleh admin, selain itu tampilkan pesan error
    public function mount()
    {
        if(auth()->user()->posisi != 'admin'){
            abort(403);
        }
    }

    // fungsi tambah produk
    public function simpan()
    {
        $this->validate([
            'nama' => 'required',
            'kode' => ['required', 'unique:produks,kode'],
            'harga' => 'required',
            'stok' => 'required'

        ],[
            'nama.required' => 'Nama harus diisi',
            'kode.required' => 'Kode harus diisi', 
            'kode.unique' => 'Kode sudah terpakai, silahkan gunakan kode lain', 
            'stok.required' => 'Stok harus diisi', 
            'harga.required' => 'Harga harus diisi' 
        ]);
        $simpan = new ModelProduk();
        $simpan->nama = $this->nama;
        $simpan->kode = $this->kode;
        $simpan->stok = $this->stok;
        $simpan->harga = $this->harga;
        $simpan->save();

        $this->reset(['nama', 'kode', 'stok', 'harga']);
        $this->pilihan_menu = 'lihat';
    }

    // fungsi edit data produk
    public function pilih_edit($id)
    {
        $this->produk_terpilih = ModelProduk::findOrfail($id);
        $this->nama = $this->produk_terpilih->nama;
        $this->kode = $this->produk_terpilih->kode;
        $this->harga = $this->produk_terpilih->harga;
        $this->stok = $this->produk_terpilih->stok;
        $this->pilihan_menu = 'edit';
    }

    // fungsi simpan data produk setelah diedit
    public function simpan_edit()
    {
        $this->validate([
            'nama' => 'required',
            'kode' => ['required', 'unique:produks,kode, ' .$this->produk_terpilih->id],
            'harga' => 'required',
            'stok' => 'required'

        ],[
            'nama.required' => 'Nama harus diisi',
            'kode.required' => 'Kode harus diisi', 
            'kode.unique' => 'Kode sudah terpakai, silahkan gunakan kode lain', 
            'stok.required' => 'Stok harus diisi', 
            'harga.required' => 'Harga harus diisi' 
        ]);
        $simpan = $this->produk_terpilih;
        $simpan->nama = $this->nama;
        $simpan->kode = $this->kode;
        $simpan->stok = $this->stok;
        $simpan->harga = $this->harga;
        $simpan->save();

        $this->reset();
        $this->pilihan_menu = 'lihat';
    }

    // fungsi hapus produk
    public function pilih_hapus($id)
    {
        $this->produk_terpilih = ModelProduk::findOrfail($id);
        $this->pilihan_menu = 'hapus';
    }
    
    // fungsi tombol hapus produk
    public function hapus()
    {
        $this->produk_terpilih->delete();
        $this->reset();
    }

    // fungsi tombol batal
    public function batal()
    {
        $this->reset();
    }

    // fungsi import produk dari Excel
    public function import_excel()
    {
        Excel::import(new ImportProduk, $this->file_excel);
        $this->reset();
    }

    public function pilih_menu($menu)
    {
        $this->pilihan_menu = $menu;
    }

    public function render()
    {
        return view('livewire.produk')->with(['semua_produk' => ModelProduk::all()]);
    }
}
