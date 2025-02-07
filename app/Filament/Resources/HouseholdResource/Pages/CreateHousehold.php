<?php

namespace App\Filament\Resources\HouseholdResource\Pages;

use App\Filament\Resources\HouseholdResource;
use App\Models\Household;
use App\Models\Member;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateHousehold extends CreateRecord
{
    protected static string $resource = HouseholdResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['created_by'] = Auth::id();
        $data['updated_by'] = Auth::id();
        $data['date_registered'] = now();

        if (isset($data['permanent_address']) && is_array($data['permanent_address'])) {
            $data['permanent_address'] = json_encode($data['permanent_address']);
        }

        return $data;
    }

    /**
     * Override the handleRecordCreation method to save family members
     */
    protected function handleRecordCreation(array $data): Household
    {

        // Create the household record
        $household = Household::create($data);

        // Check if family members exist
        if (isset($data['family_members']) && is_array($data['family_members'])) {
            foreach ($data['family_members'] as $familyMember) {
                Member::create([
                    'household_id' => $household->id, // Link to the household
                    'fullname' => $familyMember['fullname'],
                    'relation' => $familyMember['relation'],
                    'birthdate' => $familyMember['birthdate'],
                    'age' => $familyMember['age'] ?? null,
                    'sex' => $familyMember['sex'],
                    'educational_attainment' => $familyMember['education'] ?? null,
                    'occupation' => $familyMember['occupation'] ?? null,
                    'remarks' => $familyMember['remarks'] ?? null,
                    'created_by' => Auth::id(),
                    'updated_by' => Auth::id(),
                ]);
            }
        }

        return $household;
    }
}
