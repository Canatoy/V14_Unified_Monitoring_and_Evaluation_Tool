<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Municipality extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    // municipality has many students
    public function students(){
        return $this->hasMany(Student::class);
    }

    // municipality has many barangay
    public function barangays(){
        return $this->hasMany(Barangay::class);
    }
}