<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Parishioner extends Model
{
    use HasFactory;

    protected $table = 'parishioners';

    // Mass assignable attributes
    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'age',
        'birthdate',
        'address',
        'contact_number',
        'email',
        'mother_name',
        'father_name',
    ];

    // Casts to ensure proper data formatting
    protected $casts = [
        'birthdate' => 'date',
    ];
}
