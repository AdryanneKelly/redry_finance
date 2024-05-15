<?php

namespace App\Filament\Resources\RecurringBillResource\Pages;

use App\Filament\Resources\RecurringBillResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRecurringBills extends ListRecords
{
    protected static string $resource = RecurringBillResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
