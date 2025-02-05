<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'household_id',
        'fullname',
        'relation',
        'birthdate',
        'age',
        'sex',
        'educational_attainment',
        'occupation',
        'remarks',
        'created_by',
        'updated_by',
    ];

    public function household()
    {
        return $this->belongsTo(Household::class);
    }
}
