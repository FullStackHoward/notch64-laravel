<?php

namespace App\Filament\Resources\SocialIconResource\Pages;

use App\Filament\Resources\SocialIconResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSocialIcon extends EditRecord
{
    protected static string $resource = SocialIconResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
