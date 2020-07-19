<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Escala extends Model
{
    protected $table = 'sms_escala';
    public $timestamps = false;
    protected $primaryKey = ('id_productor');
}
