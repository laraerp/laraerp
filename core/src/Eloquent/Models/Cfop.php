<?php

namespace Laraerp\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;
use Laraerp\Ordination\OrdinationTrait;

class Cfop extends Model
{
    use OrdinationTrait;

    protected $primaryKey = 'codigo';
}
