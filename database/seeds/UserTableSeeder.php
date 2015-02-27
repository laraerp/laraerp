<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Laraerp\User;

class UserTableSeeder extends Seeder {

    public function run() {
        DB::table('users')->delete();

        User::create(['name' => 'Admin', 'email' => 'admin@admin.com', 'password' => Hash::make('admin')]);
    }

}
