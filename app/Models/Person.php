<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;

    //No olvidar esto, los $fillable
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
    ];
}
