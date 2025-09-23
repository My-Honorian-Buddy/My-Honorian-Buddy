<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudentResource\Pages;
use App\Filament\Resources\StudentResource\RelationManagers;
use App\Models\Student;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Enums\ActionsPosition;

class StudentResource extends Resource
{
    protected static ?string $model = Student::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationLabel = 'Students';
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
                    ])->required(),
                Forms\Components\TextInput::make('address')->required(),
                Forms\Components\Select::make('year_level') 
                    ->options([
                        '1st Year' => '1st Year',
                        '2nd Year' => '2nd Year',
                        '3rd Year' => '3rd Year',
                        '4th Year' => '4th Year',
                        '5th Year' => '5th Year',
                    ])->required(),
                Forms\Components\TextInput::make('department')->required(),
                Forms\Components\TextInput::make('rating'),
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
            'index' => Pages\ListStudents::route('/'),
            'create' => Pages\CreateStudent::route('/create'),
            'edit' => Pages\EditStudent::route('/{record}/edit'),
        ];
    }
}
