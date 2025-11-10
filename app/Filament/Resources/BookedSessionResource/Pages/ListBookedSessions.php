<?php

namespace App\Filament\Resources\BookedSessionResource\Pages;

use App\Filament\Resources\BookedSessionResource;
use App\Models\BookedSession;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\On;

class ListBookedSessions extends ListRecords
{
    protected static string $resource = BookedSessionResource::class;

    /**
     * Refresh the page every 5 seconds to show real-time updates
     * This ensures completed sessions appear immediately
     */
    protected static ?string $pollingInterval = '5s';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    /**
     * Listen for session updates and refresh the table
     */
    #[On('session-updated')]
    public function refreshTable(): void
    {
        // This will trigger a table refresh when sessions are updated
    }

    /**
     * Define navigation tabs for filtering sessions by status
     */
    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All')
                ->badge(fn () => BookedSession::withTrashed()->count())
                ->badgeColor('primary')
                ->modifyQueryUsing(fn (Builder $query) => $query->withTrashed()),

            'active' => Tab::make('Active')
                ->badge(fn () => BookedSession::whereNull('deleted_at')
                    ->where('is_completed', false)
                    ->count())
                ->badgeColor('success')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereNull('deleted_at')
                    ->where('is_completed', false)),

            'archived' => Tab::make('Archived (Completed)')
                ->badge(fn () => BookedSession::onlyTrashed()->count())
                ->badgeColor('gray')
                ->modifyQueryUsing(fn (Builder $query) => $query->onlyTrashed()),

            'pending' => Tab::make('Pending')
                ->badge(fn () => BookedSession::whereNull('deleted_at')
                    ->where('admin_approved', false)
                    ->count())
                ->badgeColor('warning')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereNull('deleted_at')
                    ->where('admin_approved', false)),

            'approved' => Tab::make('Approved')
                ->badge(fn () => BookedSession::whereNull('deleted_at')
                    ->where('admin_approved', true)
                    ->count())
                ->badgeColor('info')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereNull('deleted_at')
                    ->where('admin_approved', true)),
        ];
    }
}
