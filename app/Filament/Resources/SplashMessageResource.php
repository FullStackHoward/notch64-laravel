<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SplashMessageResource\Pages;
use App\Filament\Resources\SplashMessageResource\RelationManagers;
use App\Models\SplashMessage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SplashMessageResource extends Resource
{
    protected static ?string $model = SplashMessage::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Textarea::make('message')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('url')
                    ->label('Link URL')
                    ->url()
                    ->nullable()
                    ->placeholder('https://'),
                Forms\Components\Toggle::make('active')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('message')
                    ->searchable()
                    ->wrap(),
                Tables\Columns\TextColumn::make('url')
                    ->label('Link URL')
                    ->searchable(),
                Tables\Columns\IconColumn::make('active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListSplashMessages::route('/'),
            'create' => Pages\CreateSplashMessage::route('/create'),
            'edit' => Pages\EditSplashMessage::route('/{record}/edit'),
        ];
    }
}
