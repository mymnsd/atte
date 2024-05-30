<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'brake_id',
        'date',
        'clock_in',
        'clock_out',
    ];

    public function brake(){
        return $this->belongsTo(Brake::class);
    }
}
