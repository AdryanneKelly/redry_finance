<?php

namespace App\Filament\Resources\FixedBillResource\Pages;

use App\Filament\Resources\FixedBillResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFixedBill extends EditRecord
{
    protected static string $resource = FixedBillResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
