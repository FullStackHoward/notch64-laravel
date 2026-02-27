<?php

namespace App\Filament\Resources\CurrentlyPlayingResource\Pages;

use App\Filament\Resources\CurrentlyPlayingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCurrentlyPlayings extends ListRecords
{
    protected static string $resource = CurrentlyPlayingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
