<?php

namespace App\Filament\Resources\CurrentlyPlayingResource\Pages;

use App\Filament\Resources\CurrentlyPlayingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCurrentlyPlaying extends EditRecord
{
    protected static string $resource = CurrentlyPlayingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
