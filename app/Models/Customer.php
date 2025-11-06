<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customers';

    // Opción A (recomendada): declara fillable
    protected $fillable = [
        'id_type',
        'identification',
        'full_name',
        'phone',
        'email',
        'postal_code',
        'city',
        'canton',
        'province',
        'address',
    ];
}
