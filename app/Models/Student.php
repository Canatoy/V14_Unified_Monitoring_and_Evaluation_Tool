<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'entry_id', 'year_graduated', 'municipality_id', 'barangay_id', 'honors_received',];

    protected $casts = [
        'honors_received' => 'boolean',
    ];


    //students belongs to Municipality
    public function municipality(){
        return $this->belongsTo(Municipality::class);
    }

    //students belongs to Barangay
    public function barangay(){
        return $this->belongsTo(Barangay::class);
    }
}
