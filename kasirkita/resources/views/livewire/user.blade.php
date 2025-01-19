<div>
    <div class="container">
        <div class="row my-3">
            <div class="col-12">
                <button wire:click="pilih_menu('lihat')" class="btn {{ $pilihan_menu=='lihat' ? 'btn-secondary' : 'btn-outline-secondary' }}">Semua Pengguna</button>
                <button wire:click="pilih_menu('tambah')" class="btn {{ $pilihan_menu=='tambah' ? 'btn-secondary' : 'btn-outline-secondary' }}">Tambah Pengguna</button>
                <button wire:loading class="btn btn-info">Loading...</button>
            </div>
        </div>

        <div class="row">
            <div class="col-12">

                @if ($pilihan_menu=='lihat')
                    {{-- start list semua pengguna --}}
                    <div class="card border-primary">
                        <div class="card-header bg-primary text-white">Semua Pengguna</div>
                            <div class="card-body">

                                <table class="table table-bordered">
                                    <thead>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Posisi</th>
                                        <th>Opsi</th>
                                    </thead>

                                    <tbody>
                                        @foreach ($semua_pengguna as $pengguna)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $pengguna->name }}</td>
                                                <td>{{ $pengguna->email }}</td>
                                                <td>{{ $pengguna->posisi }}</td>
                                                <td>
                                                    <button wire:click="pilih_edit({{ $pengguna->id }})" class="btn {{ $pilihan_menu=='edit' ? 'btn-primary' : 'btn-outline-primary' }}">Edit Pengguna</button>
                                                    <button wire:click="pilih_hapus({{ $pengguna->id }})" class="btn {{ $pilihan_menu=='hapus' ? 'btn-primary' : 'btn-outline-danger' }}">Hapus Penggguna</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>

                                </table>
                            </div>
                    </div>
                    {{-- start list semua pengguna --}}

                @elseif ($pilihan_menu=='tambah')
                    {{-- start form tambah pengguna --}}
                    <div class="card border-primary">
                        <div class="card-header bg-primary text-white">Tambah Pengguna</div>

                        <div class="card-body">
                            <form wire:submit='simpan'>
                                <label>Nama</label>
                                <input type="text" class="form-control" wire:model='nama' />
                                @error('nama')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <br>

                                <label>Email</label>
                                <input type="email" class="form-control" wire:model='email' />
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <br>
                                
                                <label>Password</label>
                                <input type="password" class="form-control" wire:model='password' />
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <br>

                                <label>Posisi</label>
                                <select class="form-control" wire:model='posisi'>
                                    <option>-- pilih jabatan --</option>
                                    <option value="kasir">Kasir</option>
                                    <option value="admin">Admin</option>
                                </select>
                                <br>
                                @error('posisi')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <br>
                                <button type="button" wire:click='batal' class="btn btn-secondary mt-3">BATAL</button>
                                <button type="submit" class="btn btn-primary mt-3">SIMPAN</button>
                            </form>
                        </div>

                    </div>
                    {{-- end form tambah pengguna --}}

                @elseif ($pilihan_menu=='edit')
                    {{-- start form edit pengguna --}}
                    <div class="card border-primary">
                        <div class="card-header">Edit Pengguna</div>
                        <div class="card-body">
                            <form wire:submit='simpan_edit'>
                                <label>Nama</label>
                                <input type="text" class="form-control" wire:model='nama' />
                                @error('nama')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <br>

                                <label>Email</label>
                                <input type="email" class="form-control" wire:model='email' />
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <br>
                                
                                <label>Password</label>
                                <input type="password" class="form-control" wire:model='password' />
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <br>

                                <label>Posisi</label>
                                <select class="form-control" wire:model='posisi'>
                                    <option>-- pilih jabatan --</option>
                                    <option value="kasir">Kasir</option>
                                    <option value="kasir">Admin</option>
                                </select>
                                <br>
                                @error('posisi')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <br>
                                <button type="button" wire:click='batal' class="btn btn-secondary mt-3">BATAL</button>
                                <button type="submit" class="btn btn-primary mt-3">SIMPAN</button>
                            </form>
                        </div>
                    </div>
                    {{-- end form edit pengguna --}}

                @elseif ($pilihan_menu=='hapus')
                    {{-- start form hapus pengguna --}}
                    <div class="card border-danger">
                        <div class="card-header bg-danger text-white">Hapus Pengguna</div>
                        <div class="card-body">
                            Anda yakin ingin menghapus user ini?
                            <br>
                            <p>Nama : {{ $pengguna_terpilih->name }}</p>
                            <p>Email : {{ $pengguna_terpilih->email }}</p>
                            <p>Posisi : {{ $pengguna_terpilih->posisi }}</p>
                            <div class="btn btn-primary" wire:click='batal'>BATAL</div>
                            <div class="btn btn-danger" wire:click='hapus'>HAPUS</div>
                        </div>
                    </div>
                    {{-- end form tambah pengguna --}}

                @endif
            </div>
        </div>

    </div>
</div>
