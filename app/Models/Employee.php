<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_name',
        'employee_number',
        'employee_email',
        'employee_contact_number',
        'employee_designation',
        'company_id',
        'department_id'
    ];
}
