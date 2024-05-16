<?php

namespace App\Filament\Resources\VariantBillResource\Pages;

use App\Filament\Resources\VariantBillResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditVariantBill extends EditRecord
{
    protected static string $resource = VariantBillResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
