<?php

namespace App\Filament\Resources\SplashMessageResource\Pages;

use App\Filament\Resources\SplashMessageResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSplashMessages extends ListRecords
{
    protected static string $resource = SplashMessageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
