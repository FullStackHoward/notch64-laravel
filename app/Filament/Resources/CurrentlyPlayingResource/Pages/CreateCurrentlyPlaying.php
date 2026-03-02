<?php

namespace App\Filament\Resources\CurrentlyPlayingResource\Pages;

use App\Filament\Resources\CurrentlyPlayingResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCurrentlyPlaying extends CreateRecord
{
    protected static string $resource = CurrentlyPlayingResource::class;
}
