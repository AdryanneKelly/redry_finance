<?php

namespace App\Filament\Resources\RecurringBillResource\Pages;

use App\Filament\Resources\RecurringBillResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewRecurringBill extends ViewRecord
{
    protected static string $resource = RecurringBillResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
