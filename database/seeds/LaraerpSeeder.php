<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class LaraerpSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(UsuarioSeeder::class);
        $this->call(CidadesSeeder::class);
        $this->call(CfopsSeeder::class);
        $this->call(NcmsSeeder::class);
        $this->call(UnidadeMedidasSeeder::class);

        Model::reguard();
    }
}
