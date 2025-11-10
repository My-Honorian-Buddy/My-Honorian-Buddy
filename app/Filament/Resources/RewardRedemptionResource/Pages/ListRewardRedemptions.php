<?php

namespace App\Filament\Resources\RewardRedemptionResource\Pages;

use App\Filament\Resources\RewardRedemptionResource;
use App\Models\RewardRedemption;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListRewardRedemptions extends ListRecords
{
    protected static string $resource = RewardRedemptionResource::class;

    /**
     * Refresh the page every 5 seconds to show real-time updates
     */
    protected static ?string $pollingInterval = '5s';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    /**
     * Define navigation tabs for filtering redemptions by status
     */
    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All')
                ->badge(fn () => RewardRedemption::count())
                ->badgeColor('primary'),

            'pending' => Tab::make('Pending')
                ->badge(fn () => RewardRedemption::where('status', RewardRedemption::STATUS_PENDING)->count())
                ->badgeColor('warning')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', RewardRedemption::STATUS_PENDING)),

            'accepted' => Tab::make('Accepted')
                ->badge(fn () => RewardRedemption::where('status', RewardRedemption::STATUS_ACCEPTED)->count())
                ->badgeColor('success')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', RewardRedemption::STATUS_ACCEPTED)),

            'rejected' => Tab::make('Rejected')
                ->badge(fn () => RewardRedemption::where('status', RewardRedemption::STATUS_REJECTED)->count())
                ->badgeColor('danger')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', RewardRedemption::STATUS_REJECTED)),
        ];
    }
}
