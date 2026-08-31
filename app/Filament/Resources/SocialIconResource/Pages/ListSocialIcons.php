<?php

namespace App\Filament\Resources\SocialIconResource\Pages;

use App\Filament\Resources\SocialIconResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSocialIcons extends ListRecords
{
    protected static string $resource = SocialIconResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
