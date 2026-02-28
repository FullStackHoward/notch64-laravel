<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StreamScheduleResource\Pages;
use App\Models\StreamSchedule;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class StreamScheduleResource extends Resource
{
    protected static ?string $model = StreamSchedule::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label('Title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->label('Description')
                    ->maxLength(500)
                    ->nullable()
                    ->rows(3),
                Forms\Components\DateTimePicker::make('scheduled_at')
                    ->label('Stream Date and Time')
                    ->required(),
                Forms\Components\TextInput::make('duration_minutes')
                    ->label('Duration in minutes')
                    ->numeric()
                    ->default(60),
                Forms\Components\Toggle::make('active')
                    ->label('Active')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('scheduled_at')
                    ->label('Scheduled At')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('duration_minutes')
                    ->label('Duration mins'),
                Tables\Columns\IconColumn::make('active')
                    ->label('Active')
                    ->boolean(),
            ])
            ->defaultSort('scheduled_at')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListStreamSchedules::route('/'),
            'create' => Pages\CreateStreamSchedule::route('/create'),
            'edit'   => Pages\EditStreamSchedule::route('/{record}/edit'),
        ];
    }
}
