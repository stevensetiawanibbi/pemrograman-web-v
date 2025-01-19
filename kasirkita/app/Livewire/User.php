<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User as ModelUser;

class User extends Component
{
    public $pilihan_menu = 'lihat';
    public $nama;
    public $email;
    public $password;
    public $posisi;
    public $pengguna_terpilih;

    // fungsi PENGGUNA hanya bisa diakses oleh admin, selain itu tampilkan pesan error 403 forbidden
    public function mount()
    {
        if(auth()->user()->posisi != 'admin'){
            abort(403);
        }
    }

    // fungsi tambah user dan authentifikasi
    public function simpan()
    {
        $this->validate([
            'nama' => 'required',
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => 'required',
            'posisi' => 'required'

        ],[
            'nama.required' => 'Nama harus diisi',
            'email.required' => 'Email harus diisi', 
            'email.email' => 'Format harus email', 
            'email.unique' => 'Email sudah terpakai, silahkan gunakan email lain', 
            'password.required' => 'Password harus diisi', 
            'posisi.required' => 'Posisi harus dipilih' 
        ]);
        $simpan = new MOdelUSer();
        $simpan->name = $this->nama;
        $simpan->email = $this->email;
        $simpan->password = bcrypt($this->password);
        $simpan->posisi = $this->posisi;
        $simpan->save();

        $this->reset(['nama', 'email', 'password', 'posisi']);
        $this->pilihan_menu = 'lihat';
    }

    // fungsi edit data user
    public function pilih_edit($id)
    {
        $this->pengguna_terpilih = ModelUser::findOrfail($id);
        $this->nama = $this->pengguna_terpilih->name;
        $this->email = $this->pengguna_terpilih->email;
        $this->posisi = $this->pengguna_terpilih->posisi;
        $this->pilihan_menu = 'edit';
    }

    // fungsi simpan data user setelah diedit
    public function simpan_edit()
    {
        $this->validate([
            'nama' => 'required',
            'email' => ['required', 'email', 'unique:users,email' . $this->pengguna_terpilih->id],
            'password' => 'required',
            'posisi' => 'required'

        ],[
            'nama.required' => 'Nama harus diisi',
            'email.required' => 'Email harus diisi', 
            'email.email' => 'Format harus email', 
            'email.unique' => 'Email sudah terpakai, silahkan gunakan email lain', 
            'password.required' => 'Password harus diisi', 
            'posisi.required' => 'Posisi harus dipilih' 
        ]);
        $simpan = $this->pengguna_terpilih;
        $simpan->name = $this->nama;
        $simpan->email = $this->email;
        if($this->password)
        {
            $simpan->password = bcrypt($this->password);
        }

        $simpan->password = bcrypt($this->password);
        $simpan->posisi = $this->posisi;
        $simpan->save();

        $this->reset(['nama', 'email', 'password', 'posisi', 'pengguna_terpilih']);
        $this->pilihan_menu = 'lihat';
    }

    // fungsi hapus user
    public function pilih_hapus($id)
    {
        $this->pengguna_terpilih = ModelUser::findOrfail($id);
        $this->pilihan_menu = 'hapus';
    }
    
    // fungsi tombol hapus user
    public function hapus()
    {
        $this->pengguna_terpilih->delete();
        $this->reset();
    }

    // fungsi tombol batal
    public function batal()
    {
        $this->reset();
    }

    public function pilih_menu($menu)
    {
        $this->pilihan_menu = $menu;
    }

    public function render()
    {
        return view('livewire.user')->with(['semua_pengguna' => ModelUser::all()]);
    }
}
