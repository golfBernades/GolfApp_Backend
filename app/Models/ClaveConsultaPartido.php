<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClaveConsultaPartido extends Model
{
    protected $table = 'clave_consulta_partido';
    public $timestamps = false;
    protected $primaryKey = 'clave';
    public $incrementing = false;
}
