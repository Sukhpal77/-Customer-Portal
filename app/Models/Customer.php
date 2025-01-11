<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $table = 'customers';

    protected $fillable = [
        'first_name',
        'last_name',
        'age',
        'dob',
        'email',
        'creation_date',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
