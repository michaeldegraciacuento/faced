<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Family extends Model
{
    use HasFactory;

    protected $fillable = [
        'household_id',
        'name',
        'relation',
        'birthdate',
        'age',
        'sex',
        'education',
        'occupation',
        'remarks',
    ];

    public function household()
    {
        return $this->belongsTo(Household::class);
    }
}
