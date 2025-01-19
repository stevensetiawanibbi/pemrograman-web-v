<?php

namespace App\Imports; // import produk dari excel 

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use App\Models\Produk as ModelProduk;

class Produk implements ToCollection, WithStartRow
{
    public function startRow(): int{ // fungsi menampilkan data dlm bentuk row
        return 1;
    }
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection) // fungsi simpan data dari excel
    {
        foreach($collection as $col) // cek apakah data produk sudah ada di database atau belum
        {
            $kodeyangadadidatabase = ModelProduk::where('kode', $col[1])->first();
            if (!$kodeyangadadidatabase) {
                $simpan = new ModelProduk();
                $simpan->kode = $col[1];
                $simpan->nama = $col[2];
                $simpan->harga = $col[3];
                $simpan->stok = $col[4];
                $simpan->save();
            }
        }
    }
}
