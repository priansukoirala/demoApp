<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'department_name',
        'company_id',
        'creator_user_id'
    ];


    public function company()
    {
        return $this->belongsTo(Employee::class);
    }

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
}
