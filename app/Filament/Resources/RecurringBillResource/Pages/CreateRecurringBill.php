<?php

namespace App\Filament\Resources\RecurringBillResource\Pages;

use App\Filament\Resources\RecurringBillResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateRecurringBill extends CreateRecord
{
    protected static string $resource = RecurringBillResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();

        return $data;
    }
}
