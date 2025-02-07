<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HouseholdResource\Pages;
use App\Filament\Resources\HouseholdResource\RelationManagers;
use App\Models\Household;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Fieldset;
use Filament\Tables\Actions\Action;


class HouseholdResource extends Resource
{
    protected static ?string $model = Household::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Wizard::make([
                    // Step 1: Location Details
                    Wizard\Step::make('Location')
                        ->schema([
                            Grid::make(3)
                                ->schema([
                                    TextInput::make('region')
                                        ->label('Region')
                                        ->default('Region X')
                                        ->disabled()
                                        ->dehydrated(true)
                                        ->required(),
                                    TextInput::make('municipality')
                                        ->label('Municipality')
                                        ->default('Gitagum')
                                        ->disabled()
                                        ->dehydrated(true)
                                        ->required(),
                                    TextInput::make('province')
                                        ->label('Province')
                                        ->default('Misamis Oriental')
                                        ->disabled()
                                        ->dehydrated(true)
                                        ->required(),
                                    Select::make('barangay')
                                        ->label('Barangay')
                                        ->options([
                                            'Poblacion' => 'Poblacion',
                                            'Burnay' => 'Burnay',
                                            'Pangayawan' => 'Pangayawan',
                                            'Matangad' => 'Matangad',
                                            'Cogon' => 'Cogon',
                                            'Quezon' => 'Quezon',
                                            'Kilangit' => 'Kilangit',
                                            'C.P Garcia' => 'C.P Garcia',
                                            'G. Pelaez' => 'G. Pelaez',
                                            'Tala-o' => 'Tala-o',
                                            'Ulab' => 'Ulab',
                                        ])
                                        ->afterStateUpdated(function ($state, callable $set) {
                                            $set('permanent_address.barangay', $state); // Update the permanent_address.barangay field
                                        })
                                        ->default(fn($get) => $get('barangay'))
                                        ->required(),
                                    TextInput::make('district')
                                        ->label('District')
                                        ->default('2nd')
                                        ->disabled()
                                        ->dehydrated(true),
                                    TextInput::make('evacuation_center')
                                        ->label('Evacuation Center')
                                        ->required(),
                                ])
                        ]),

                    // Step 2: Head of Household Details
                    Wizard\Step::make('Head of Household')
                        ->schema([
                            Grid::make(3) // Make this step three columns
                                ->schema([
                                    TextInput::make('lastname')->label('Last Name')->required(),
                                    TextInput::make('firstname')->label('First Name')->required(),
                                    TextInput::make('middlename')->label('Middle Name'),
                                    TextInput::make('name_ext')->label('Name Extension'),
                                    DatePicker::make('birthdate')
                                        ->label('Birthdate')
                                        ->reactive()
                                        ->afterStateUpdated(function ($state, callable $set) {
                                            if ($state) {
                                                try {
                                                    // Parse the birthdate using Carbon
                                                    $birthdate = \Carbon\Carbon::parse($state);

                                                    // Calculate the absolute age difference in years
                                                    $age = intval(abs(now()->diffInYears($birthdate)));
                                                    $set('age', $age);
                                                } catch (\Exception $e) {
                                                    // Handle invalid dates or exceptions gracefully
                                                    $set('age', null);
                                                }
                                            } else {
                                                // Reset age if the state is empty
                                                $set('age', null);
                                            }
                                        })
                                        ->required(),
                                    TextInput::make('age')
                                        ->label('Age')
                                        ->disabled()
                                        ->dehydrated(true)
                                        ->default(fn($get) => $get('birthdate') ? intval(abs(now()->diffInYears(\Carbon\Carbon::parse($get('birthdate'))))) : null),
                                    TextInput::make('birthplace')
                                        ->label("Birthplace")
                                        ->required(),
                                    Select::make('sex')
                                        ->label('Sex')
                                        ->options(['Male' => 'Male', 'Female' => 'Female'])
                                        ->required(),
                                    Select::make('civil_status')
                                        ->label('Civil Status')
                                        ->options(['Single' => 'Single', 'Married' => 'Married', 'Cohabitation' => 'Cohabitation', 'Separated' => 'Separated', 'Widow/er' => 'Widow/er'])
                                        ->required(),
                                    TextInput::make('mothers_maiden_name')
                                        ->label("Mother's Maiden Name")
                                        ->required(),
                                    TextInput::make('occupation')->label('Occupation'),
                                    Select::make('religion')
                                        ->label('Religion')
                                        ->options([
                                            'Roman Catholic' => 'Roman Catholic',
                                            'Islam' => 'Islam',
                                            'Iglesia ni Cristo' => 'Iglesia ni Cristo',
                                            'Seventh Day Adventist' => 'Seventh Day Adventist',
                                            'Aglipay' => 'Aglipay',
                                            'Iglesia Filipina Independiente' => 'Iglesia Filipina Independiente',
                                            'Bible Baptist Church' => 'Bible Baptist Church',
                                            'UCCP' => 'UCCP',
                                            'Jehovah’s Witness' => 'Jehovah’s Witness',
                                            'Church Of Christ' => 'Church Of Christ',
                                            'Born Again Christians' => 'Born Again Christians',
                                            'Other Religious Affiliations' => 'Other Religious Affiliations',
                                            'Protestant' => 'Protestant',
                                            'LDS-Mormons' => 'LDS-Mormons',
                                            'Evangelical' => 'Evangelical',
                                            'N/A (Not Required)' => 'N/A (Not Required)',
                                        ]),
                                    TextInput::make('contact_number_primary')
                                        ->label('Primary Contact Number')
                                        ->required(),
                                    TextInput::make('contact_number_alternate')
                                        ->label('Alternate Contact Number'),
                                    TextInput::make('monthly_family_income')
                                        ->label('Monthly Family Income'),
                                    Select::make('id_card_presented')
                                        ->label('ID Card Presented')
                                        ->options([
                                            'ACR/ICR' => 'ACR/ICR',
                                            'Driver’s License' => 'Driver’s License',
                                            'GSIS e-Card' => 'GSIS e-Card',
                                            'Passport' => 'Passport',
                                            'Postal ID' => 'Postal ID',
                                            'PRC ID' => 'PRC ID',
                                            'School ID' => 'School ID',
                                            'Senior Citizen Card' => 'Senior Citizen Card',
                                            'SSS Card' => 'SSS Card',
                                            'Unified Multi-purpose ID' => 'Unified Multi-purpose ID',
                                            'Voter’s ID' => 'Voter’s ID',
                                            'PhilSys ID' => 'PhilSys ID',
                                            'Company ID' => 'Company ID',
                                            'PhilHealth ID' => 'PhilHealth ID',
                                            'TIN' => 'TIN',
                                        ]),
                                    TextInput::make('id_card_number')
                                        ->label('ID Card Number'),
                                ]),
                            Fieldset::make('Permanent Address')
                                ->schema([
                                    TextInput::make('permanent_address.block')
                                        ->label('Block')
                                        ->statePath('permanent_address.block'),  // Add statePath
                                    Select::make('permanent_address.street')
                                        ->label('Street')
                                        ->options([
                                            '1' => '1',
                                            '2' => '3',
                                            '2A' => '2A',
                                            '2B' => '2B',
                                            '3' => '3',
                                            '3A' => '3A',
                                            '3B' => '3B',
                                            '4' => '4',
                                            '5' => '5',
                                            '6' => '6',
                                            '6A' => '6A',
                                            '6B' => '6B',
                                            '7' => '7',
                                            '8' => '8',
                                            '9' => '9',
                                        ])
                                        ->required()
                                        ->statePath('permanent_address.street'),  // Add statePath
                                    TextInput::make('permanent_address.subdivision')
                                        ->label('Subdivision')
                                        ->statePath('permanent_address.subdivision'),  // Add statePath
                                    TextInput::make('permanent_address.barangay')
                                        ->label('Barangay')
                                        ->disabled()
                                        ->dehydrated(true)
                                        ->statePath('permanent_address.barangay'),  // Add statePath
                                    TextInput::make('permanent_address.city')
                                        ->label('City')
                                        ->default('Gitagum')
                                        ->disabled()
                                        ->dehydrated(true)
                                        ->statePath('permanent_address.city'),  // Add statePath
                                    TextInput::make('permanent_address.province')
                                        ->label('Province')
                                        ->default('Misamis Oriental')
                                        ->disabled()
                                        ->dehydrated(true)
                                        ->statePath('permanent_address.province'),  // Add statePath
                                    TextInput::make('permanent_address.zipcode')
                                        ->label('Zip Code')
                                        ->default('9020')
                                        ->disabled()
                                        ->dehydrated(true)
                                        ->statePath('permanent_address.zipcode'),  // Add statePath
                                ])
                                ->columns(3),
                        ]),
                    // Step 3: Family Members
                    Wizard\Step::make('Family Members')
                        ->schema([
                            Repeater::make('family_members')
                                ->label('Family Members')
                                ->dehydrated()
                                ->schema([
                                    Grid::make(3)
                                        ->schema([
                                            TextInput::make('fullname')->label('Name'),
                                            Select::make('relation')
                                                ->label('Relation')
                                                ->options([
                                                    'Brother' => 'Brother',
                                                    'Sister' => 'Sister',
                                                    'Spouse' => 'Spouse',
                                                    'Mother' => 'Mother',
                                                    'Father' => 'Father',
                                                    'Son' => 'Son',
                                                    'Daughter' => 'Daughter',
                                                    'Cohabitation' => 'Cohabitation',
                                                    'Cousin' => 'Cousin',
                                                    'Friend' => 'Friend',
                                                    'Grandmother' => 'Grandmother',
                                                    'Grandfather' => 'Grandfather',
                                                    'Auntie' => 'Auntie',
                                                    'Uncle' => 'Uncle',
                                                    'Niece' => 'Niece',
                                                    'Nephew' => 'Nephew',
                                                    'Brother-in-Law' => 'Brother-in-Law',
                                                    'Sister-in-Law' => 'Sister-in-Law',
                                                    'Mother-in-Law' => 'Mother-in-Law',
                                                    'Father-in-Law' => 'Father-in-Law',
                                                    'Grandson' => 'Grandson',
                                                    'Granddaughter' => 'Granddaughter',
                                                    'Step Son' => 'Step Son',
                                                    'Step Daughter' => 'Step Daughter',
                                                    'Daughter In Law' => 'Daughter In Law',
                                                    'Son In Law' => 'Son In Law',
                                                ]),
                                            DatePicker::make('birthdate')
                                                ->label('Birthdate')
                                                ->reactive()
                                                ->afterStateUpdated(function ($state, callable $set) {
                                                    if ($state) {
                                                        try {
                                                            // Parse the birthdate using Carbon
                                                            $birthdate = \Carbon\Carbon::parse($state);

                                                            // Calculate the absolute age difference in years
                                                            $age = intval(abs(now()->diffInYears($birthdate)));
                                                            $set('age', $age);
                                                        } catch (\Exception $e) {
                                                            // Handle invalid dates or exceptions gracefully
                                                            $set('age', null);
                                                        }
                                                    } else {
                                                        // Reset age if the state is empty
                                                        $set('age', null);
                                                    }
                                                }),
                                            TextInput::make('age')
                                                ->label('Age')
                                                ->disabled() // Prevent user input
                                                ->dehydrated(true) // Ensure the value is included in form submission
                                                ->default(fn($get) => $get('birthdate') ? intval(abs(now()->diffInYears(\Carbon\Carbon::parse($get('birthdate'))))) : null),
                                            Select::make('sex')
                                                ->label('Sex')
                                                ->options(['Male' => 'Male', 'Female' => 'Female']),
                                            Select::make('education')
                                                ->label('Education')
                                                ->options([
                                                    'Pre-school' => 'Pre-school',
                                                    'Elementary Level' => 'Elementary Level',
                                                    'Elementary Student' => 'Elementary Student',
                                                    'Elementary Graduate' => 'Elementary Graduate',
                                                    'High School Level' => 'High School Level',
                                                    'High School Student' => 'High School Student',
                                                    'High School Graduate' => 'High School Graduate',
                                                    'Senior High School' => 'Senior High School',
                                                    'Advance Learning System' => 'Advance Learning System',
                                                    'College Level' => 'College Level',
                                                    'College Graduate' => 'College Graduate',
                                                    'College Student' => 'College Student',
                                                    'Masteral' => 'Masteral',
                                                    'Doctorate' => 'Doctorate',
                                                    'Post Graduate' => 'Post Graduate',
                                                    'Vocational Course' => 'Vocational Course',
                                                    'N/A (Not Required)' => 'N/A (Not Required)',
                                                ]),
                                            TextInput::make('occupation')->label('Occupation'),
                                            Textarea::make('remarks')->label('Remarks'),
                                        ])
                                ])
                                ->createItemButtonLabel('Add Family Member'),
                        ]),

                    // Step 4: Additional Information
                    // Step 4: Additional Information
                    Wizard\Step::make('Additional Information')
                        ->schema([
                            Grid::make(3) // Set the grid to have 3 columns
                                ->schema([
                                    TextInput::make('older_person')
                                        ->label('Number of Older Persons')
                                        ->numeric(),
                                    TextInput::make('pregnant')
                                        ->label('Number of Pregnant Women')
                                        ->numeric(),
                                    TextInput::make('lactating')
                                        ->label('Number of Lactating Women')
                                        ->numeric(),
                                    TextInput::make('pwds')
                                        ->label('Number of PWDs')
                                        ->numeric(),
                                    Select::make('ownership')
                                        ->label('Ownership')
                                        ->options([
                                            'owner' => 'Owner',
                                            'renter' => 'Renter',
                                            'sharer' => 'Sharer',
                                        ])
                                        ->required(),
                                    Select::make('shelter_damage_classification')
                                        ->label('Shelter Damage Classification')
                                        ->options([
                                            'partially_damage' => 'Partially Damaged',
                                            'totally_damage' => 'Totally Damaged',
                                        ]),
                                    Select::make('name_barangay_captain')
                                        ->label('Barangay Captain')
                                        ->options([
                                            'Frederico D. Lim Jr' => 'Frederico D. Lim Jr',
                                            'Andy F. Peneda' => 'Andy F. Peneda',
                                            'Bienvenido O. Jamis' => 'Bienvenido O. Jamis',
                                            'Jeofrey A. Tagarda' => 'Jeofrey A. Tagarda',
                                            'Mary Robert M. Buray' => 'Mary Robert M. Buray',
                                            'Jim P. Jamis' => 'Jim P. Jamis',
                                            'Remar R. Rafal' => 'Remar R. Rafal',
                                            'Leon M. Aguipo Jr' => 'Leon M. Aguipo Jr',
                                            'Jaisan T. Donque Sr' => 'Jaisan T. Donque Sr',
                                            'Hernando M. Jabla' => 'Hernando M. Jabla',
                                            'Emerita S. Baculio' => 'Emerita S. Baculio',
                                        ]),
                                    TextInput::make('name_of_lswdo')
                                        ->label('LSWDO Name')
                                        ->disabled()
                                        ->dehydrated(true)
                                        ->default('Genelyn Obsioma'),
                                ]),
                        ]),
                ])
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('lastname')->label('Last Name')->sortable()->searchable(),
                TextColumn::make('firstname')->label('First Name')->sortable()->searchable(),
                TextColumn::make('barangay')->label('Barangay')->sortable(),
                TextColumn::make('contact_number_primary')->label('Contact Number'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Action::make('form')
                    ->label('Form')                      // Button Label
                    ->icon('heroicon-o-document')       // Optional Icon
                    ->url(fn($record) => route('household.pdf-form', $record->id)) // Dynamic URL
                    ->openUrlInNewTab(),                // Opens PDF in a new tab

                Tables\Actions\EditAction::make(),      // Existing Edit button
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHouseholds::route('/'),
            'create' => Pages\CreateHousehold::route('/create'),
            'edit' => Pages\EditHousehold::route('/{record}/edit'),
        ];
    }
}
