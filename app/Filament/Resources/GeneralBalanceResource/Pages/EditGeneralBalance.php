<?php

namespace App\Filament\Resources\GeneralBalanceResource\Pages;

use App\Filament\Resources\GeneralBalanceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGeneralBalance extends EditRecord
{
    protected static string $resource = GeneralBalanceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
