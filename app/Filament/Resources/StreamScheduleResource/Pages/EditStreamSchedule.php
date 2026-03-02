<?php

namespace App\Filament\Resources\StreamScheduleResource\Pages;

use App\Filament\Resources\StreamScheduleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStreamSchedule extends EditRecord
{
    protected static string $resource = StreamScheduleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
