<?php

namespace App\Filament\Resources\MainTileResource\Pages;

use App\Filament\Resources\MainTileResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMainTile extends EditRecord
{
    protected static string $resource = MainTileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
