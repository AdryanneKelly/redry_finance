<?php

namespace App\Filament\Resources\GeneralBalanceResource\Pages;

use App\Filament\Resources\GeneralBalanceResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewGeneralBalance extends ViewRecord
{
    protected static string $resource = GeneralBalanceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
