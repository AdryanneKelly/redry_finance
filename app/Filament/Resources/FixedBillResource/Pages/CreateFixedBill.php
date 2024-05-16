<?php

namespace App\Filament\Resources\FixedBillResource\Pages;

use App\Filament\Resources\FixedBillResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateFixedBill extends CreateRecord
{
    protected static string $resource = FixedBillResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();

        return $data;
    }
}
