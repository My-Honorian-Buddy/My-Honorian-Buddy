<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TutorResource\Pages;
use App\Filament\Resources\TutorResource\RelationManagers;
use App\Models\Tutor;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Enums\ActionsPosition;
use Filament\Tables\Table;
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TutorResource extends Resource
{
    protected static ?string $model = Tutor::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';
    protected static ?string $navigationLabel = 'Tutors';
    protected static ?string $navigationGroup = 'Accounts';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('user_id')->required()->label('User ID'),
                Forms\Components\TextInput::make('fname')->required()->label('First Name'),
                Forms\Components\TextInput::make('lname')->required()->label('Last Name'),
                Forms\Components\Select::make('role') 
                    ->options([
                        'Male' => 'Male',
                        'Female' => 'Female',
                    ]),
                Forms\Components\TextInput::make('address'),
                Forms\Components\Select::make('year_level') 
                    ->options([
                        '1st Year' => '1st Year',
                        '2nd Year' => '2nd Year',
                        '3rd Year' => '3rd Year',
                        '4th Year' => '4th Year',
                        '5th Year' => '5th Year',
                    ]),
                Forms\Components\TextInput::make('department'),
                Forms\Components\TextInput::make('rating'),
                Forms\Components\TextInput::make('exp'),
                Forms\Components\Textarea::make('bio'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('fname')->sortable()->searchable()->label('First Name'),
                Tables\Columns\TextColumn::make('lname')->sortable()->searchable()->label('Last Name'),
                Tables\Columns\TextColumn::make('gender'),
                Tables\Columns\TextColumn::make('address'),
                Tables\Columns\TextColumn::make('year_level'),
                Tables\Columns\TextColumn::make('department'),
                Tables\Columns\TextColumn::make('rating')->default('No rating yet'),
                Tables\Columns\TextColumn::make('exp')->default('No experience yet'),
                Tables\Columns\TextColumn::make('bio')->default('None'),
            ])
            ->filters([
                //
            ])
            ->actions([
                DeleteAction::make(),
                Tables\Actions\EditAction::make(),
            ], position: ActionsPosition::BeforeCells)
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
            'index' => Pages\ListTutors::route('/'),
            'create' => Pages\CreateTutor::route('/create'),
            'edit' => Pages\EditTutor::route('/{record}/edit'),
        ];
    }
}
