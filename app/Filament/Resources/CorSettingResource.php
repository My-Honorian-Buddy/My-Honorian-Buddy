<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CorSettingResource\Pages;
use App\Filament\Resources\CorSettingResource\RelationManagers;
use App\Models\CorSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CorSettingResource extends Resource
{
    protected static ?string $model = CorSetting::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-check';

    protected static ?string $navigationLabel = 'COR Verification Settings';

    protected static ?string $navigationGroup = 'System Settings';

    protected static ?int $navigationSort = 10;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('University Information')
                    ->description('Configure the university details that will be verified in COR documents')
                    ->schema([
                        Forms\Components\TextInput::make('university_name')
                            ->label('University Name')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('e.g., PAMPANGA STATE AGRICULTURAL UNIVERSITY')
                            ->helperText('This will be verified in the COR PDF'),

                        Forms\Components\TextInput::make('cor_title')
                            ->label('COR Document Title')
                            ->required()
                            ->default('Certificate of Registration')
                            ->maxLength(255)
                            ->helperText('Usually "Certificate of Registration"'),

                        Forms\Components\TextInput::make('campus_name')
                            ->label('Campus Name')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('e.g., Magalang Campus')
                            ->helperText('The specific campus location'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Academic Period')
                    ->description('Set the academic year and validity period')
                    ->schema([
                        Forms\Components\TextInput::make('academic_year')
                            ->label('Academic Year')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('e.g., AY 2025-2026')
                            ->helperText('Format: AY YYYY-YYYY'),

                        Forms\Components\DatePicker::make('valid_from')
                            ->label('Valid From')
                            ->required()
                            ->default(now())
                            ->helperText('Start date for this setting'),

                        Forms\Components\DatePicker::make('valid_until')
                            ->label('Valid Until')
                            ->required()
                            ->default(now()->addYear())
                            ->helperText('End date for this setting')
                            ->after('valid_from'),
                    ])
                    ->columns(3),

                Forms\Components\Section::make('Additional Settings')
                    ->schema([
                        Forms\Components\Toggle::make('is_active')
                            ->label('Active')
                            ->default(true)
                            ->helperText('Only one setting can be active at a time')
                            ->inline(false),

                        Forms\Components\TagsInput::make('additional_keywords')
                            ->label('Additional Keywords (Optional)')
                            ->placeholder('Add more keywords to verify')
                            ->helperText('Press Enter after each keyword. These will be checked in addition to the main fields.')
                            ->separator(','),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('university_name')
                    ->label('University')
                    ->searchable()
                    ->sortable()
                    ->wrap(),

                Tables\Columns\TextColumn::make('academic_year')
                    ->label('Academic Year')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('info'),

                Tables\Columns\TextColumn::make('campus_name')
                    ->label('Campus')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean()
                    ->sortable(),

                Tables\Columns\TextColumn::make('valid_from')
                    ->label('Valid From')
                    ->date()
                    ->sortable(),

                Tables\Columns\TextColumn::make('valid_until')
                    ->label('Valid Until')
                    ->date()
                    ->sortable()
                    ->color(fn ($record) => $record->valid_until < now() ? 'danger' : 'success'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active Status')
                    ->placeholder('All settings')
                    ->trueLabel('Active only')
                    ->falseLabel('Inactive only'),

                Tables\Filters\Filter::make('valid_now')
                    ->label('Currently Valid')
                    ->query(fn (Builder $query) => $query
                        ->where('valid_from', '<=', now())
                        ->where('valid_until', '>=', now())
                    ),

                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('activate')
                    ->label('Set Active')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->action(fn (CorSetting $record) => $record->update(['is_active' => true]))
                    ->requiresConfirmation()
                    ->visible(fn (CorSetting $record) => !$record->is_active),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
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
            'index' => Pages\ListCorSettings::route('/'),
            'create' => Pages\CreateCorSetting::route('/create'),
            'edit' => Pages\EditCorSetting::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getNavigationBadge(): ?string
    {
        $active = CorSetting::getActive();
        return $active ? '1 Active' : 'No Active';
    }

    public static function getNavigationBadgeColor(): ?string
    {
        $active = CorSetting::getActive();
        return $active ? 'success' : 'danger';
    }
}
