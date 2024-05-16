<?php

namespace App\Filament\Resources\FixedBillResource\Pages;

use App\Filament\Resources\FixedBillResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewFixedBill extends ViewRecord
{
    protected static string $resource = FixedBillResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
