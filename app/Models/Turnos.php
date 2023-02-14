<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Turnos extends Model
{
    use HasFactory;

    static $rules = [
        'start'=>'required',
        'end'=>'required',
        'id_doctor'=>'required',
        'cupos'=>'required',
        'intervalos'=>'required'
    ];
    protected $fillable = ['id_doctor','start','end','cupos','intervalos'];
}
