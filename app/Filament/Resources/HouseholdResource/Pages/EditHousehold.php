<?php

namespace App\Filament\Resources\HouseholdResource\Pages;

use App\Filament\Resources\HouseholdResource;
use Filament\Actions;
use App\Models\Member;
use App\Models\Household;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;

class EditHousehold extends EditRecord
{
    protected static string $resource = HouseholdResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    
    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    /**
     * Decode permanent_address JSON before filling the form
     */
    protected function mutateFormDataBeforeFill(array $data): array
    {
        if (isset($data['permanent_address']) && is_string($data['permanent_address'])) {
            $data['permanent_address'] = json_decode($data['permanent_address'], true);
        }

        $data['family_members'] = Member::where('household_id', $this->record->id)
            ->get()
            ->map(function ($member) {
                return [
                    'id' => $member->id, // Add ID to track existing members
                    'fullname' => $member->fullname,
                    'relation' => $member->relation,
                    'birthdate' => $member->birthdate,
                    'age' => $member->age,
                    'sex' => $member->sex,
                    'education' => $member->educational_attainment,
                    'occupation' => $member->occupation,
                    'remarks' => $member->remarks,
                ];
            })
            ->toArray();

        return $data;
    }

    // Encode JSON before saving
    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (isset($data['permanent_address']) && is_array($data['permanent_address'])) {
            $data['permanent_address'] = json_encode($data['permanent_address']);
        }

        return $data;
    }

    /**
     * ✅ Correct Method Signature
     */
    protected function handleRecordUpdate($record, array $data): Household
    {
        // Update household data
        $originalData = $record->only(array_keys($data));

        if ($this->hasDataChanged($originalData, $data)) {
            // Add 'updated_by' if data has changed
            $data['updated_by'] = Auth::id();
        }
        $record->update($data);

        // Handle family members
        $existingMemberIds = $record->members()->pluck('id')->toArray();
        $submittedMemberIds = collect($data['family_members'])->pluck('id')->filter()->toArray();

        // 1️⃣ Delete members that were removed
        $membersToDelete = array_diff($existingMemberIds, $submittedMemberIds);
        Member::destroy($membersToDelete);

        // 2️⃣ Update existing members or add new ones
        foreach ($data['family_members'] as $memberData) {
            if (isset($memberData['id'])) {
                // Fetch the existing member
                $existingMember = Member::find($memberData['id']);

                // Check if the existing member exists and if any data has changed
                if ($existingMember) {
                    $fieldsToCheck = [
                        'fullname',
                        'relation',
                        'birthdate',
                        'age',
                        'sex',
                        'educational_attainment',
                        'occupation',
                        'remarks'
                    ];

                    $hasChanged = false;

                    foreach ($fieldsToCheck as $field) {
                        $newValue = $memberData[$field] ?? ($field === 'educational_attainment' ? $memberData['education'] ?? null : null);
                        if ($existingMember->{$field} != $newValue) {
                            $hasChanged = true;
                            break;
                        }
                    }

                    // Only update if there are changes
                    if ($hasChanged) {
                        $existingMember->update([
                            'fullname' => $memberData['fullname'],
                            'relation' => $memberData['relation'],
                            'birthdate' => $memberData['birthdate'],
                            'age' => $memberData['age'],
                            'sex' => $memberData['sex'],
                            'educational_attainment' => $memberData['education'] ?? null,
                            'occupation' => $memberData['occupation'] ?? null,
                            'remarks' => $memberData['remarks'] ?? null,
                            'updated_by' => Auth::id(), // Only updated when data changes
                        ]);
                    }
                }
            } else {
                // Add new member
                Member::create([
                    'household_id' => $record->id,
                    'fullname' => $memberData['fullname'],
                    'relation' => $memberData['relation'],
                    'birthdate' => $memberData['birthdate'],
                    'age' => $memberData['age'] ?? null,
                    'sex' => $memberData['sex'],
                    'educational_attainment' => $memberData['education'] ?? null,
                    'occupation' => $memberData['occupation'] ?? null,
                    'remarks' => $memberData['remarks'] ?? null,
                    'created_by' => Auth::id(),
                    'updated_by' => Auth::id(), // Always set for new records
                ]);
            }
        }


        return $record;
    }
    protected function hasDataChanged(array $original, array $newData): bool
    {
        foreach ($newData as $key => $value) {
            if (array_key_exists($key, $original) && $original[$key] != $value) {
                return true; // Data has changed
            }
        }
        return false; // No changes
    }
}
