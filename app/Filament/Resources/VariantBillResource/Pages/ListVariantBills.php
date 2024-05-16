<?php

namespace App\Filament\Resources\VariantBillResource\Pages;

use App\Filament\Resources\VariantBillResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListVariantBills extends ListRecords
{
    protected static string $resource = VariantBillResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
