<?php

namespace App\Filament\Resources\CommunityTileResource\Pages;

use App\Filament\Resources\CommunityTileResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCommunityTiles extends ListRecords
{
    protected static string $resource = CommunityTileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
