<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;

    protected $fillable = [
        'level_code',
        'level_name'
    ];

    public function employeePeriods() {
        return $this->hasMany(EmployeePeriod::class);
    }
}
