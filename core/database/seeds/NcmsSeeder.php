<?php

use Illuminate\Database\Seeder;
use Laraerp\Eloquent\Models\Ncm;

class NcmsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('Seed Nomeclatura Comum do Mercosul..');

        DB::disableQueryLog();

        $reflector = new ReflectionClass(Seeder::class);
        $vendorPath = dirname($reflector->getFileName()).'/../../../../../';

        $csvPath = $vendorPath.'jansenfelipe/ncm/ncm.csv';

        if(is_file($csvPath)){

            /*
             * Lendo NCM's
             */
            $ncms = array();

            $qtd = 0;
            $handle = fopen($csvPath, "r");
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                $qtd++;
                $i = intval($qtd/500);
                if(isset($data[0]) && isset($data[1]))
                    $ncms[$i][] = ['codigo' => $data[0], 'descricao' => $data[1]];
            }

            /*
             * Inserindo NCM's
             */
            $qtd = count($ncms);

            foreach ($ncms as $key => $rows) {
                $key++;
                $this->command->info("Inserindo NCMs $key/$qtd ..");

                Ncm::insert($rows);
            }
        }else
            $this->command->info('.csv nao encontrado..');
    }
}
