<?php

namespace App\Filament\Widgets;

use App\Models\Member;
use App\Models\Household;
use Filament\Widgets\ChartWidget;

class GenderDistribution extends ChartWidget
{
    protected static ?string $heading = 'Gender Distribution (Members & Households)';
    protected static ?int $sort = 3; // Optional: Control the display order

    protected function getData(): array
    {
        // Count Male and Female in Members
        $memberMaleCount = Member::where('sex', 'Male')->count();
        $memberFemaleCount = Member::where('sex', 'Female')->count();

        // Count Male and Female in Households
        $householdMaleCount = Household::where('sex', 'Male')->count();
        $householdFemaleCount = Household::where('sex', 'Female')->count();

        // Combine the counts
        $totalMale = $memberMaleCount + $householdMaleCount;
        $totalFemale = $memberFemaleCount + $householdFemaleCount;

        return [
            'labels' => ['Male', 'Female'],
            'datasets' => [
                [
                    'data' => [$totalMale, $totalFemale],
                    'backgroundColor' => ['#36A2EB', '#FF6384'], // Colors for Male & Female
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'pie'; // Specify the chart type
    }

    public function getColumns(): int | string | array
    {
        return [
            'md' => 4,
            'xl' => 5,
        ];
    }
}
