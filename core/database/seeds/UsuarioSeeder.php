<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('Seed usuario: admin@admin.com');

        //Limpando tabelas
        DB::table('users')->delete();

        //Criando usuario admin
        User::create(['name' => 'Admin', 'email' => 'admin@admin.com', 'password' => Hash::make('admin')]);
    }
}
