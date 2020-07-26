<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $table = 'sms_pedido';
    public $timestamps = false;
    protected $primaryKey = 'codigo';
}
