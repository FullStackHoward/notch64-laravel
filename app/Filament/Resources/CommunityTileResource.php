<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CommunityTileResource\Pages;
use App\Filament\Support\LinkTileForm;
use App\Models\LinkTile;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class CommunityTileResource extends Resource
{
    protected static ?string $model = LinkTile::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationGroup = 'Links';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationLabel = 'Community Tiles';

    protected static ?string $modelLabel = 'community tile';

    protected static ?string $pluralModelLabel = 'Community Tiles';

    protected static ?string $slug = 'link-tiles/community';

    /**
     * All three link rows share the link_tiles table; each resource sees only
     * its own section so that drag-to-reorder sorts that row in isolation.
     */
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('section', LinkTile::SECTION_COMMUNITY);
    }

    public static function form(Form $form): Form
    {
        return $form->schema(LinkTileForm::schema(LinkTile::SECTION_COMMUNITY));
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
            'index' => Pages\ListCommunityTiles::route('/'),
            'create' => Pages\CreateCommunityTile::route('/create'),
            'edit' => Pages\EditCommunityTile::route('/{record}/edit'),
        ];
    }
}
