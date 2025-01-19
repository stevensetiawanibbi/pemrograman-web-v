<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class data_awal extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void // data dummy
    {
        $user = new User();
        $user->name = 'Admin';
        $user->email = 'admin@gmail.com';
        $user->password = bcrypt('244466666');
        $user->posisi = 'admin';
        $user->save();
    }
}
