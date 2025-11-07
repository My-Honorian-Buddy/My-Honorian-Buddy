<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BannedSessionArchiveResource\Pages;
use App\Filament\Resources\BannedSessionArchiveResource\RelationManagers;
use App\Models\BannedSessionArchive;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BannedSessionArchiveResource extends Resource
{
    protected static ?string $model = BannedSessionArchive::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box';
    
    protected static ?string $navigationLabel = 'Banned Sessions Archive';
    
    protected static ?string $modelLabel = 'Banned Session';
    
    protected static ?string $pluralModelLabel = 'Banned Sessions Archive';
    
    protected static ?string $navigationGroup = 'Session Management';
    
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('original_session_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('student_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('tutor_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('student_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('tutor_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('tutoring_subject')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\DateTimePicker::make('schedule_time')
                    ->required(),
                Forms\Components\TextInput::make('duration')
                    ->numeric(),
                Forms\Components\TextInput::make('status')
                    ->maxLength(255),
                Forms\Components\TextInput::make('num_session')
                    ->numeric(),
                Forms\Components\TextInput::make('total_session')
                    ->numeric(),
                Forms\Components\Textarea::make('feedback')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('room')
                    ->maxLength(255),
                Forms\Components\Toggle::make('is_completed')
                    ->required(),
                Forms\Components\Toggle::make('reviewed')
                    ->required(),
                Forms\Components\Textarea::make('ban_reason')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\DateTimePicker::make('ban_requested_at'),
                Forms\Components\Textarea::make('tutor_report')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('tutor_report_images'),
                Forms\Components\DateTimePicker::make('tutor_report_submitted_at'),
                Forms\Components\TextInput::make('ban_status')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DateTimePicker::make('banned_at'),
                Forms\Components\TextInput::make('banned_by')
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tutor_name')
                    ->label('Tutor')
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-m-user-circle')
                    ->iconColor('danger'),
                    
                Tables\Columns\TextColumn::make('student_name')
                    ->label('Student')
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-m-user')
                    ->iconColor('danger'),
                    
                Tables\Columns\TextColumn::make('tutoring_subject')
                    ->label('Subject')
                    ->searchable()
                    ->limit(30)
                    ->wrap(),
                    
                Tables\Columns\TextColumn::make('schedule_time')
                    ->label('Session Date')
                    ->dateTime('M d, Y h:i A')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('session_progress')
                    ->label('Progress')
                    ->state(fn ($record) => ($record->num_session ?? 0) . ' / ' . ($record->total_session ?? 0))
                    ->badge()
                    ->color('gray'),
                    
                Tables\Columns\TextColumn::make('ban_status')
                    ->label('Ban Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'approved' => 'danger',
                        'rejected' => 'success',
                        default => 'warning',
                    }),
                    
                Tables\Columns\TextColumn::make('banned_at')
                    ->label('Banned On')
                    ->dateTime('M d, Y h:i A')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('ban_reason')
                    ->label('Ban Reason')
                    ->limit(50)
                    ->tooltip(fn ($record) => $record->ban_reason)
                    ->toggleable(),
            ])
            ->defaultSort('banned_at', 'desc')
            ->filters([
                Tables\Filters\Filter::make('banned_at')
                    ->form([
                        Forms\Components\DatePicker::make('from')
                            ->label('From Date'),
                        Forms\Components\DatePicker::make('until')
                            ->label('Until Date'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('banned_at', '>=', $date),
                            )
                            ->when(
                                $data['until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('banned_at', '<=', $date),
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->modalHeading('Banned Session Details')
                    ->modalWidth('5xl'),
            ])
            ->bulkActions([
                // No bulk actions - archive should be preserved
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
            'index' => Pages\ListBannedSessionArchives::route('/'),
            // No create or edit - this is a read-only archive
        ];
    }
    
    public static function canCreate(): bool
    {
        return false;
    }
    
    public static function canEdit($record): bool
    {
        return false;
    }
    
    public static function canDelete($record): bool
    {
        return false;
    }
}
