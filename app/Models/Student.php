<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = ['fullname', 'municipality_id', 'barangay_id'];

    public function municipality (){
        return $this->belongsTo(Municipality::class);
    }

    public function barangay(){
        return $this->belongsTo(Barangay::class);
    }
}
