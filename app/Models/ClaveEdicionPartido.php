<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClaveEdicionPartido extends Model
{
    protected $table = 'clave_edicion_partido';
    public $timestamps = false;
    protected $primaryKey = 'clave';
    public $incrementing = false;
}
