<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contrato extends Model
{
    protected $table = 'sms_contrato';
    public $timestamps = false;
    protected $primaryKey = ('codigo');
}
