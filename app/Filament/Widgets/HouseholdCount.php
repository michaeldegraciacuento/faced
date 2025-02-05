<?php

namespace App\Filament\Widgets;

use App\Models\Household;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class HouseholdCount extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Card::make('Total Household', Household::count())
                ->description('All registered Household')
                ->icon('heroicon-o-user-group') // Optional icon
                ->color('success'),             // Optional color
        ];
    }
    public function getColumnSpan(): int | string | array
    {
        return [
            'md' => 6,
            'xl' => 5,
        ]; // Use a simple integer for column span
    }
    protected static ?int $sort = 1;
}
