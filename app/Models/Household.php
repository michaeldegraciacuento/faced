<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Household extends Model
{
    use HasFactory;

    protected $fillable = [
        'region',
        'municipality',
        'province',
        'barangay',
        'district',
        'evacuation_center',
        'lastname',
        'firstname',
        'middlename',
        'name_ext',
        'birthdate',
        'age',
        'birthplace',
        'permanent_address',
        'sex',
        'civil_status',
        'mothers_maiden_name',
        'religion',
        'occupation',
        'monthly_family_income',
        'id_card_presented',
        'id_card_number',
        'contact_number_primary',
        'contact_number_alternate',
        '4ps_beneficiary',
        'type_of_ethnicity',
        'older_person',
        'pregnant',
        'lactating',
        'pwds',
        'ownership',
        'shelter_damage_classification',
        'signature_family_head',
        'name_barangay_captain',
        'signature_barangay_captain',
        'date_registered',
        'name_of_lswdo',
        'signature_of_lswdo',
        'created_by',
        'updated_by',
    ];

    public function members()
    {
        return $this->hasMany(Member::class);
    }

    public function families()
    {
        return $this->hasMany(Family::class);
    }
}
