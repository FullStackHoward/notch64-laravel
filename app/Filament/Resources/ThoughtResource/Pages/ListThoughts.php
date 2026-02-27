<?php

namespace App\Filament\Resources\ThoughtResource\Pages;

use App\Filament\Resources\ThoughtResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListThoughts extends ListRecords
{
    protected static string $resource = ThoughtResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
