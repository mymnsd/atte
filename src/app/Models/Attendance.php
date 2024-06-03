<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'rest_id',
        'date',
        'start_time',
        'end_time',
    ];

    public function rest(){
        return $this->belongsTo(Rest::class);
    }
}
