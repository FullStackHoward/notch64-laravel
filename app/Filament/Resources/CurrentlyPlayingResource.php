<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CurrentlyPlayingResource\Pages;
use App\Filament\Resources\CurrentlyPlayingResource\RelationManagers;
use App\Models\CurrentlyPlaying;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CurrentlyPlayingResource extends Resource
{
    protected static ?string $model = CurrentlyPlaying::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label('Game Title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('platform')
                    ->label('Platform')
                    ->required()
                    ->options([
                        'PlayStation' => 'PlayStation',
                        'Xbox'        => 'Xbox',
                        'Steam'       => 'Steam',
                        'Nintendo'    => 'Nintendo',
                        'Apple Arcade'=> 'Apple Arcade',
                        'Android'     => 'Android',
                        'Other'       => 'Other',
                    ]),
                Forms\Components\TextInput::make('cover_url')
                    ->label('Cover Image URL')
                    ->url()
                    ->nullable()
                    ->placeholder('https://'),
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
                    ->label('Game Title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('platform')
                    ->label('Platform')
                    ->badge(),
                Tables\Columns\IconColumn::make('active')
                    ->boolean(),
            ])
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
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCurrentlyPlayings::route('/'),
            'create' => Pages\CreateCurrentlyPlaying::route('/create'),
            'edit' => Pages\EditCurrentlyPlaying::route('/{record}/edit'),
        ];
    }
}
