<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasFactory;



    protected $fillable = 
    ['name', 
     'entry_id',
     'year_graduated',
     'municipality',
     'barangay',
     'honors_received',
     'employment',
     'status',
     'college_course',
     'vocational',
     'others',
     'remarks',
    ];

    protected $casts = [
        'honors_received' => 'boolean',
    ];
}
