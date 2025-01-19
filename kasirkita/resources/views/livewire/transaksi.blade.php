<div>
    <div class="container">
        {{-- start button --}}
        <div class="row my-3">
            <div class="col-12">
                {{-- jika tidak ada transaksi aktif maka tombol batalkan transaksi hilang --}}
                @if (!$transaksi_aktif) 
                    <button class="btn btn-primary" wire:click='transaksi_baru'>Buat Transaksi Baru</button>
                @else
                    <button class="btn btn-danger" wire:click='batal_transaksi'>Batalkan Transaksi</button>
                @endif
                    <button class="btn btn-info" wire:loading>Loading...</button>
            </div>
        </div>
        {{-- end button --}}

        {{-- start form buat transaksi baru --}}
        {{-- jika ada transaksi aktif maka tampilkan detail pembelian dan pembayaran --}}
        @if($transaksi_aktif) 
        <div class="row mt-2">
            <div class="col-9">
                <div class="card border-primary">
                    <div class="card-body">
                        <h4 class="card-title">No. Invoice : {{ $transaksi_aktif->kode }}</h4>
                            <input type="text" class="form-control" placeholder="Masukkan Kode Barang" wire:model.live='kode'>
                            <table class="table table-bordered mt-3">
                                <thead>
                                    <th>No</th>
                                    <th>Kode barang</th>
                                    <th>Nama barang</th>
                                    <th>Harga</th>
                                    <th>Qty</th>
                                    <th>Subtotal</th>
                                    <th>Opsi</th>
                                </thead>
                            
                            @foreach ($semua_produk as $produk)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $produk->produk->kode }}</td>
                                    <td>{{ $produk->produk->nama }}</td>
                                    <td>{{ number_format($produk->produk->harga, 2, '.', ',') }}</td>
                                    <td>
                                        {{ $produk->jumlah }}
                                    </td>
                                    <td>
                                        {{ number_format($produk->produk->harga * $produk->jumlah, 2, '.', ',') }}
                                    </td>
                                    <td>
                                        <button class="btn btn-danger" wire:click='hapus_produk({{ $produk->id }})'>Hapus</button>
                                    </td>
                                </tr>
                            @endforeach
                            </table>
                    </div>
                </div>
            </div>
        {{-- end form buat transaksi baru (kiri)--}}

        {{-- start total bayar (kanan) --}}
            <div class="col-3">
                <div class="card border-primary">
                    <div class="card-body">
                        <h4 class="card-title">Total Biaya</h4>
                        <div class="d-flex justify-content-between">
                            <span>Rp</span>
                            <span>{{ number_format($total_semua_belanja,2, '.', ',') }}</span>
                        </div>
                    </div>
                </div>
                <div class="card border-primary mt-3">
                    <div class="card-body">
                        <h4 class="card-title">Bayar</h4>
                        <input type="number" class="form-control" placeholder="Nominal Uang" wire:model.live='bayar'>
                    </div>
                </div>
                <div class="card border-primary mt-3">
                    <div class="card-body">
                        <h4 class="card-title">Kembalian</h4>
                        <div class="d-flex justify-content-between">
                            <span>Rp</span>
                            <span>{{ number_format($kembalian,2, '.', ',') }}</span>
                        </div>
                    </div>
                </div>
                
                {{-- jika uang yang diinput kurang dari 0 maka jangan tampilkan tombol bayar --}}
                @if ($bayar)
                    @if ($kembalian < 0) 
                        <div class="alert alert-danger mt-2" role="alert">
                            Uang Kurang
                        </div>
                    @elseif ($kembalian > 0)
                        <button class="btn btn-success mt-3 w-100" wire:click='transaksi_selesai'>Bayar</button>
                    @endif
                @endif
            </div>
        {{-- end total bayar (kanan) --}}
            
        </div>
        @endif
    </div>
</div>
