<?php

namespace App\Filament\Resources\GeneralBalanceResource\Pages;

use App\Filament\Resources\GeneralBalanceResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateGeneralBalance extends CreateRecord
{
    protected static string $resource = GeneralBalanceResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();

        return $data;
    }
}
