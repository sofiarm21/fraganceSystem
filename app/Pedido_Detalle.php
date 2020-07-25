<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pedido_Detalle extends Model
{
    protected $table = 'sms_det_pedido';
    public $timestamps = false;
    protected $primaryKey = ['cod_pedido','id'];
}
