<?php

namespace App\Filament\Widgets;

use App\Models\Member;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class MemberCount extends BaseWidget
{

    protected function getCards(): array
    {
        return [
            Card::make('Total Members', Member::count())
                ->description('All registered members')
                ->icon('heroicon-o-users')
                ->color('info'),
        ];
    }
    public function getColumnSpan(): int | string | array
    {
        return [
            'md' => 4,
            'xl' => 5,
        ]; // Use a simple integer for column span
    }

    protected static ?int $sort = 2;
}
