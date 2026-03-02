<?php

namespace App\Filament\Resources\PlatformStatResource\Pages;

use App\Filament\Resources\PlatformStatResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPlatformStat extends EditRecord
{
    protected static string $resource = PlatformStatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
