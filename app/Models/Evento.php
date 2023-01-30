<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    use HasFactory;

    static $rules = [
        'title'=>'required',
        'description'=>'required',
        'start'=>'required',
        'end'=>'required'
    ],
    $messages = [
        'title.required'=> 'Falta rellenar el campo title',
    ];
    protected $fillable = ['title', 'description', 'start', 'end'];
}
