<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Barangay extends Model
{
    use HasFactory;

    protected $fillable = [
        'municipality_id',
        'barangay'
    ]; //susudlan ha database

    // barangay belongs to municipality
    public function municipality(){
        return $this->belongsTo(Municipality::class);
    }

    // barangay has many students
    public function students(){
        return $this->hasMany(Student::class);
    }
}
