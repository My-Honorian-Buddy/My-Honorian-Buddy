<?php

namespace App\Filament\Widgets;

use App\Models\Student;
use App\Models\Tutor;
use App\Models\User;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class UserWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Number of Users', User::count())
            ->description('Users that are currently logged in.')
            ->descriptionIcon('heroicon-s-user', IconPosition::Before)
            ->color('success'),


            Stat::make('Number of Students', Student::count())
            ->description('Students that are currently logged in.')
            ->descriptionIcon('heroicon-s-user', IconPosition::Before)
            ->color('success'),

            Stat::make('Number of Tutors', Tutor::count())
            ->description('Tutors that are currently logged in.')
            ->descriptionIcon('heroicon-s-user', IconPosition::Before)
            ->color('success'),
        ];
    }
}
