<?php

namespace App\Filament\Resources\FixedBillResource\Pages;

use App\Filament\Resources\FixedBillResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFixedBills extends ListRecords
{
    protected static string $resource = FixedBillResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
