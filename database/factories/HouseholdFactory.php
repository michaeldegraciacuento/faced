<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Household>
 */
class HouseholdFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'region' => $this->faker->state,
            'municipality' => $this->faker->city,
            'province' => $this->faker->state,
            'barangay' => $this->faker->streetName,
            'district' => $this->faker->word,
            'evacuation_center' => $this->faker->company,
            'lastname' => $this->faker->lastName,
            'firstname' => $this->faker->firstName,
            'middlename' => $this->faker->lastName,
            'name_ext' => $this->faker->randomElement(['Jr.', 'Sr.', null]),
            'birthdate' => $this->faker->date,
            'age' => $this->faker->numberBetween(1, 100),
            'birthplace' => $this->faker->city,
            'permanent_address' => $this->faker->address,
            'sex' => $this->faker->randomElement(['Male', 'Female']),
            'civil_status' => $this->faker->randomElement(['Single', 'Married', 'Widowed']),
            'mothers_maiden_name' => $this->faker->name,
            'religion' => $this->faker->randomElement(['Catholic', 'Muslim', 'Other']),
            'occupation' => $this->faker->jobTitle,
            'monthly_family_income' => $this->faker->randomFloat(2, 0, 10000),
            'id_card_presented' => $this->faker->word,
            'id_card_number' => $this->faker->numerify('############'),
            'contact_number_primary' => $this->faker->phoneNumber,
            'contact_number_alternate' => $this->faker->phoneNumber,
            '4ps_beneficiary' => $this->faker->boolean,
            'type_of_ethnicity' => $this->faker->word,
            'older_person' => $this->faker->numberBetween(0, 1),
            'pregnant' => $this->faker->numberBetween(0, 1),
            'lactating' => $this->faker->numberBetween(0, 1),
            'pwds' => $this->faker->numberBetween(0, 1),
            'ownership' => $this->faker->word,
            'shelter_damage_classification' => $this->faker->word,
            'signature_family_head' => $this->faker->name,
            'name_barangay_captain' => $this->faker->name,
            'signature_barangay_captain' => $this->faker->name,
            'date_registered' => $this->faker->date,
            'name_of_lswdo' => $this->faker->name,
            'signature_of_lswdo' => $this->faker->name,
            'created_by' => 1, // Assign a default user ID for created_by
            'updated_by' => null,
        ];
    }
}
