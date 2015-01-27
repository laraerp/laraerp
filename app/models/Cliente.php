<?php

use LaravelBook\Ardent\Ardent;

class Cliente extends Ardent {

    protected $table = 'tb_cliente';
    protected $fillable = array(
        'fk_pessoa',
        'inscricao_estadual',
        'inscricao_municipal',
        'retem_issqn',
    );
    public static $rules = array(
        'fk_pessoa' => 'required|numeric|exists:tb_pessoa,id',
    );

    /**
     * Belongs to Pessoa
     */
    public function pessoa() {
        return $this->belongsTo('Laraerp\Pessoa\Models\Pessoa', 'fk_pessoa');
    }

}