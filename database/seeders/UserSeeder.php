<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    //Create UserSeeder così sarò sempre in login in fase di sviluppo
    public function run()
    {
        $user = new User();
        $user->name = "Pasquale";
        $user->email = "admin@email.it";
        $user->password = Hash::make('password');

        $user->save();
    }
}