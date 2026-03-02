<?php

namespace App\Filament\Resources\PlatformStatResource\Pages;

use App\Filament\Resources\PlatformStatResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions;

class ListPlatformStats extends ListRecords
{
    protected static string $resource = PlatformStatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
