<?php

namespace App\Filament\Resources\MasDesignationResource\Pages;

use App\Filament\Resources\MasDesignationResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMasDesignation extends EditRecord
{
    protected static string $resource = MasDesignationResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
