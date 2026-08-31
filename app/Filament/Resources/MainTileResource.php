<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MainTileResource\Pages;
use App\Filament\Support\LinkTileForm;
use App\Models\LinkTile;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class MainTileResource extends Resource
{
    protected static ?string $model = LinkTile::class;

    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';

    protected static ?string $navigationGroup = 'Links';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationLabel = 'Main Tiles';

    protected static ?string $modelLabel = 'main tile';

    protected static ?string $pluralModelLabel = 'Main Tiles';

    protected static ?string $slug = 'link-tiles/main';

    /**
     * All three link rows share the link_tiles table; each resource sees only
     * its own section so that drag-to-reorder sorts that row in isolation.
     */
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('section', LinkTile::SECTION_MAIN);
    }

    public static function form(Form $form): Form
    {
        return $form->schema(LinkTileForm::schema(LinkTile::SECTION_MAIN));
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns(LinkTileForm::columns(true))
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->reorderRecordsTriggerAction(
                fn (Tables\Actions\Action $action, bool $isReordering) => $action
                    ->button()
                    ->label($isReordering ? 'Done reordering' : 'Reorder tiles'),
            )
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMainTiles::route('/'),
            'create' => Pages\CreateMainTile::route('/create'),
            'edit' => Pages\EditMainTile::route('/{record}/edit'),
        ];
    }
}
