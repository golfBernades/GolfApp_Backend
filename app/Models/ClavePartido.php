<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClavePartido extends Model
{
    protected $table = 'clave_partido';
    public $timestamps = false;
    protected $primaryKey = 'clave';
    public $incrementing = false;
}
