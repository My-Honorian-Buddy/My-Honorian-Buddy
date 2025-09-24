<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RewardRedemptionResource\Pages;
use App\Filament\Resources\RewardRedemptionResource\RelationManagers;
use App\Models\RewardRedemption;
use App\Status;
use Dom\Text;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Actions\Action;

class RewardRedemptionResource extends Resource
{
    protected static ?string $model = RewardRedemption::class;

    protected static ?string $navigationIcon = 'heroicon-o-gift';
    protected static ?string $navigationLabel = 'Rewards Redemption';
    protected static ?string $navigationGroup = 'Points System';
 

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('tutor.user.name')->label('Tutor')->sortable(),
                TextColumn::make('reward.name')->label('Reward')->sortable(),
                TextColumn::make('status')->badge()->formatStateUsing(fn ($state) => ucfirst($state))->colors([
                    'warning' => 'pending',
                    'success' => 'accepted',
                    'danger' => 'rejected',
                ]),
                TextColumn::make('created_at')->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Action::make('Accept')
                ->visible(fn ($record) => $record->status == 'pending')
                ->action(function (RewardRedemption $record) {
                    $record->update(['status' => 'accepted']);
                })
                ->requiresConfirmation()
                ->color('success'),

                Action::make('Reject')
                ->visible(fn ($record) => $record->status == 'pending')
                ->action(function (RewardRedemption $record) {
                    $record->update(['status' => 'rejected']);
                })
                ->requiresConfirmation()
                ->color('danger'),
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
            'index' => Pages\ListRewardRedemptions::route('/'),

        ];
    }
}
