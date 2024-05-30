<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brake extends Model
{
    use HasFactory;

    protected $fillable = [
        'clock_in',
        'clock_out',
    ];
}
