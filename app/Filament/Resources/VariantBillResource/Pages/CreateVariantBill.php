<?php

namespace App\Filament\Resources\VariantBillResource\Pages;

use App\Filament\Resources\VariantBillResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateVariantBill extends CreateRecord
{
    protected static string $resource = VariantBillResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();

        return $data;
    }
}
