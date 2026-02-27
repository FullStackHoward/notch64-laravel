<?php

namespace App\Filament\Resources\SplashMessageResource\Pages;

use App\Filament\Resources\SplashMessageResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSplashMessage extends EditRecord
{
    protected static string $resource = SplashMessageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
