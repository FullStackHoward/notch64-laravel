<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PlatformStatResource\Pages;
use App\Models\PlatformStat;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PlatformStatResource extends Resource
{
    protected static ?string $model = PlatformStat::class;

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('platform')
                    ->label('Platform')
                    ->required()
                    ->options([
                        'PlayStation'  => 'PlayStation',
                        'Xbox'         => 'Xbox',
                        'Nintendo'     => 'Nintendo',
                        'Steam'        => 'Steam',
                        'Apple Arcade' => 'Apple Arcade',
                        'Android'      => 'Android',
                        'Other'        => 'Other',
                    ]),
                Forms\Components\TextInput::make('stat_label')
                    ->label('Stat Label')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('stat_value')
                    ->label('Stat Value')
                    ->required()
                    ->maxLength(255),
                Forms\Components\FileUpload::make('icon_path')
                    ->label('8-bit Icon')
                    ->directory('icons/stats')
                    ->disk('public')
                    ->nullable(),
                Forms\Components\Toggle::make('active')
                    ->label('Active')
                    ->default(true),
                Forms\Components\TextInput::make('sort_order')
                    ->label('Sort Order')
                    ->numeric()
                    ->default(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('platform')
                    ->label('Platform')
                    ->badge()
                    ->searchable(),
                Tables\Columns\TextColumn::make('stat_label')
                    ->label('Stat Label')
                    ->searchable(),
                Tables\Columns\TextColumn::make('stat_value')
                    ->label('Stat Value'),
                Tables\Columns\ImageColumn::make('icon_path')
                    ->label('Icon')
                    ->disk('public'),
                Tables\Columns\IconColumn::make('active')
                    ->label('Active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Sort Order')
                    ->sortable(),
            ])
            ->defaultSort('sort_order')
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
            'index'  => Pages\ListPlatformStats::route('/'),
            'create' => Pages\CreatePlatformStat::route('/create'),
            'edit'   => Pages\EditPlatformStat::route('/{record}/edit'),
        ];
    }
}
