<?php

namespace App\Filament\Resources\VariantBillResource\Pages;

use App\Filament\Resources\VariantBillResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewVariantBill extends ViewRecord
{
    protected static string $resource = VariantBillResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
