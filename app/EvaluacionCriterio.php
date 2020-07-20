<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EvaluacionCriterio extends Model
{
    protected $table = 'sms_eval_criterio';
    public $timestamps = false;
    protected $primaryKey = ('id_productor');
}
