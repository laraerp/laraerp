<?php

namespace Laraerp\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;
use Laraerp\Ordination\OrdinationTrait;

class UnidadeMedida extends Model
{
    use OrdinationTrait;

    protected $fillable = ['id', 'descricao'];
}
