<?php

namespace App\Filament\Resources\RecurringBillResource\Pages;

use App\Filament\Resources\RecurringBillResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRecurringBill extends EditRecord
{
    protected static string $resource = RecurringBillResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
