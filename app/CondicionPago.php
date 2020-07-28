<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CondicionPago extends Model
{
    protected $table = 'sms_condicion_pago';
    public $timestamps = false;
    protected $primaryKey = ('codigo');
}
