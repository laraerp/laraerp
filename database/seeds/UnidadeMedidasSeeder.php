<?php

use Illuminate\Database\Seeder;
use Laraerp\Eloquent\Models\UnidadeMedida;
use Laraerp\Eloquent\Models\UnidadeMedidaFator;
use Laraerp\Eloquent\Models\UnidadeMedidaFatorSinonimo;

class UnidadeMedidasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $this->command->info('Seed Unidades de medida..');

        /*
         * Unidade de medida
         */
        $quantitativo = UnidadeMedida::create(['descricao' => 'Quantitativo (Un, duzia..)']);
        $massa = UnidadeMedida::create(['descricao' => 'Massa (Kg, g..)']);
        $volume = UnidadeMedida::create(['descricao' => 'Volume (L, ml..)']);


        /*
         * Fatores
         */

        //Quantitativo
        $un = UnidadeMedidaFator::create(['unidade_medida_id' => $quantitativo->id, 'simbolo' => 'Un', 'fator' => 1]);
        $duzia = UnidadeMedidaFator::create(['unidade_medida_id' => $quantitativo->id, 'simbolo' => 'Duzia', 'fator' => 12]);

        //Massa
        $kg = UnidadeMedidaFator::create(['unidade_medida_id' => $massa->id, 'simbolo' => 'Kg', 'fator' => 1000]);
        $g = UnidadeMedidaFator::create(['unidade_medida_id' => $massa->id, 'simbolo' => 'g', 'fator' => 1]);

        //Volume
        $L = UnidadeMedidaFator::create(['unidade_medida_id' => $volume->id, 'simbolo' => 'L', 'fator' => 1]);
        $ml = UnidadeMedidaFator::create(['unidade_medida_id' => $volume->id, 'simbolo' => 'ml', 'fator' => 0.001]);


        /*
         * Sinônimos
         */

        //un
        UnidadeMedidaFatorSinonimo::create(['unidade_medida_fator_id' => $un->id, 'simbolo' => 'uni']);

        //duzia
        UnidadeMedidaFatorSinonimo::create(['unidade_medida_fator_id' => $duzia->id, 'simbolo' => 'dz']);

        //Kg
        UnidadeMedidaFatorSinonimo::create(['unidade_medida_fator_id' => $kg->id, 'simbolo' => 'quilo']);
        UnidadeMedidaFatorSinonimo::create(['unidade_medida_fator_id' => $kg->id, 'simbolo' => 'kilo']);

        //g
        UnidadeMedidaFatorSinonimo::create(['unidade_medida_fator_id' => $g->id, 'simbolo' => 'grama']);

        //L
        UnidadeMedidaFatorSinonimo::create(['unidade_medida_fator_id' => $L->id, 'simbolo' => 'litro']);

        //ml
        UnidadeMedidaFatorSinonimo::create(['unidade_medida_fator_id' => $ml->id, 'simbolo' => 'mililitro']);
    }
}
