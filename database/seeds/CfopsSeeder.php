<?php

use Illuminate\Database\Seeder;
use Laraerp\Eloquent\Models\Cfop;

class CfopsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('Seed Codigo Fiscal de Operacao e Prestacao..');

        DB::disableQueryLog();

        $reflector = new ReflectionClass(Seeder::class);
        $vendorPath = dirname($reflector->getFileName()).'/../../../../../';

        $csvPath = $vendorPath.'jansenfelipe/cfop/cfop.csv';

        if(is_file($csvPath)){

            /*
             * Lendo CFOP's
             */
            $cfops = array();

            $qtd = 0;
            $handle = fopen($csvPath, "r");
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                $qtd++;
                $i = intval($qtd/500);
                if(isset($data[0]) && isset($data[1]))
                    $cfops[$i][] = ['codigo' => $data[0], 'descricao' => $data[1]];
            }

            /*
             * Inserindo CFOP's
             */
            $qtd = count($cfops);

            foreach ($cfops as $key => $rows) {
                $key++;
                $this->command->info("Inserindo CFOPs $key/$qtd ..");

                Cfop::insert($rows);
            }
        }else
            $this->command->info('.csv nao encontrado..');
    }
}
