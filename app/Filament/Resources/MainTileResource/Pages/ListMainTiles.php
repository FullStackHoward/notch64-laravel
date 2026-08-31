<?php

namespace App\Filament\Resources\MainTileResource\Pages;

use App\Filament\Resources\MainTileResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMainTiles extends ListRecords
{
    protected static string $resource = MainTileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
