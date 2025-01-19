<div>
    <div class="container">
        {{-- start button --}}
        <div class="row my-3">
            <div class="col-12">
                <button wire:click="pilih_menu('lihat')" class="btn {{ $pilihan_menu=='lihat' ? 'btn-secondary' : 'btn-outline-secondary' }}">Semua Produk</button>
                <button wire:click="pilih_menu('tambah')" class="btn {{ $pilihan_menu=='tambah' ? 'btn-secondary' : 'btn-outline-secondary' }}">Tambah Produk</button>
                <button wire:click="pilih_menu('excel')" class="btn {{ $pilihan_menu=='excel' ? 'btn-secondary' : 'btn-outline-secondary' }}">Import Data Produk</button>
                <button wire:loading class="btn btn-info">Loading...</button>
            </div>
        </div>
        {{-- end button --}}
    
        <div class="row">
            <div class="col-12">
                
                @if ($pilihan_menu=='lihat')
                    {{-- start list semua produk --}}
                    <div class="card border-primary">
                        <div class="card-header bg-primary text-white">Semua produk</div>
                            <div class="card-body">

                                <table class="table table-bordered"> 
                                    <thead>
                                        <th>No</th>
                                        <th>Kode</th>
                                        <th>Nama Produk</th>
                                        <th>Harga</th>
                                        <th>Stok</th>
                                        <th>Opsi</th>
                                    </thead>

                                    <tbody> 
                                        @foreach ($semua_produk as $produk)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $produk->kode }}</td>
                                                <td>{{ $produk->nama }}</td>
                                                <td>{{ $produk->harga }}</td>
                                                <td>{{ $produk->stok }}</td>
                                                <td>
                                                    <button wire:click="pilih_edit({{ $produk->id }})" class="btn {{ $pilihan_menu=='edit' ? 'btn-primary' : 'btn-outline-primary' }}">
                                                        Edit Produk
                                                    </button>
                                                    <button wire:click="pilih_hapus({{ $produk->id }})" class="btn {{ $pilihan_menu=='hapus' ? 'btn-primary' : 'btn-outline-danger' }}">
                                                        Hapus Produk
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>

                                </table>
                            </div>
                    </div>
                    {{-- end list semua produk --}}

                 @elseif ($pilihan_menu=='tambah')
                    {{-- start form tambah produk --}}
                    <div class="card border-primary">
                        <div class="card-header bg-primary text-white">Tambah produk</div>
                        <div class="card-body">
                            <form wire:submit='simpan'>
                                <label>Kode</label>
                                <input type="text" class="form-control" wire:model='kode' />
                                @error('kode')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <br>
                                
                                <label>Nama Produk</label>
                                <input type="text" class="form-control" wire:model='nama' />
                                @error('nama')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <br>

                                <label>Harga</label>
                                <input type="number" class="form-control" wire:model='harga' />
                                @error('harga')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <br>
                                
                                <label>Stok</label>
                                <input type="number" class="form-control" wire:model='stok' />
                                <br>
                                @error('stok')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <br>
                                <button type="submit" class="btn btn-primary mt-3">SIMPAN</button>
                            </form>
                        </div>
                    </div>
                    {{-- end form tambah produk --}}

                @elseif ($pilihan_menu=='edit')
                    {{-- start form edit produk --}}
                    <div class="card border-primary">
                        <div class="card-header">Edit produk</div>
                        <div class="card-body">
                            <form wire:submit='simpan_edit'>
                                <label>Kode</label>
                                <input type="text" class="form-control" wire:model='kode' />
                                @error('kode')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <br>
                                
                                <label>Nama Produk</label>
                                <input type="text" class="form-control" wire:model='nama' />
                                @error('nama')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <br>

                                <label>Harga</label>
                                <input type="number" class="form-control" wire:model='harga' />
                                @error('harga')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <br>
                                
                                <label>Stok</label>
                                <input type="number" class="form-control" wire:model='stok' />
                                <br>
                                @error('stok')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <br>
                                <button type="button" wire:click='batal' class="btn btn-secondary mt-3">BATAL</button>
                                <button type="submit" class="btn btn-primary mt-3">SIMPAN</button>
                            </form>
                        </div>
                    </div>
                    {{-- end form edit produk --}}

                @elseif ($pilihan_menu=='hapus')
                    {{-- start form hapus produk --}}
                    <div class="card border-danger">
                        <div class="card-header bg-danger text-white">Hapus produk</div>
                        <div class="card-body">
                            Anda yakin ingin menghapus produk ini?
                            <br>
                            <p>Kode : {{ $produk_terpilih->kode }}</p>
                            <p>Nama : {{ $produk_terpilih->nama }}</p>
                            <p>Harga : {{ $produk_terpilih->harga }}</p>
                            <div class="btn btn-primary" wire:click='batal'>BATAL</div>
                            <div class="btn btn-danger" wire:click='hapus'>HAPUS</div>
                        </div>
                    </div>
                    {{-- end form hapus produk --}}

                @elseif ($pilihan_menu=='excel')
                    {{-- start form import data produk --}}
                    <div class="card border-primary">
                        <div class="card-header bg-primary text-white">Import data produk</div>
                        <div class="card-body">
                            <form wire:submit='import_excel'>
                                <input type="file" class="form-control" wire:model='file_excel'><br>
                                <button class="btn btn-primary" type="submit">Kirim File</button>
                            </form>
                        </div>
                    </div>
                    {{-- end form import data produk --}}
                @endif
            </div>
        </div>

    </div>
</div>
