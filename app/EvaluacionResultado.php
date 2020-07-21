<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EvaluacionResultado extends Model
{
    protected $table = 'sms_evaluacion_resultado';
    public $timestamps = false;
    protected $primaryKey = 'fecha_realizada';
}
