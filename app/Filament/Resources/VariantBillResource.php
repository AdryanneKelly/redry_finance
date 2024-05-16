<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VariantBillResource\Pages;
use App\Filament\Resources\VariantBillResource\RelationManagers;
use App\Models\VariantBill;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class VariantBillResource extends Resource
{
    protected static ?string $model = VariantBill::class;

    protected static ?string $modelLabel = 'Contas variantes';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Contas';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('category_id')
                    ->relationship('category', 'name')
                    ->label('Categoria')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->createOptionForm([
                        Forms\Components\TextInput::make('name')
                            ->label('Nome')
                            ->required(),
                    ]),
                Forms\Components\TextInput::make('title')
                    ->label('Título')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('value')
                    ->label('Valor')
                    ->required()
                    ->prefix('R$')
                    ->numeric(),
                Forms\Components\DatePicker::make('purchase_date')
                    ->label('Data da compra')
                    ->native(false)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Categoria')
                    ->sortable(),
                Tables\Columns\TextColumn::make('title')
                    ->label('Título')
                    ->searchable(),
                Tables\Columns\TextColumn::make('value')
                    ->money('BRL')
                    ->label('Valor')
                    ->sortable(),
                Tables\Columns\TextColumn::make('purchase_date')
                    ->date('d/m/Y')
                    ->label('Data da compra')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVariantBills::route('/'),
            'create' => Pages\CreateVariantBill::route('/create'),
            'view' => Pages\ViewVariantBill::route('/{record}'),
            'edit' => Pages\EditVariantBill::route('/{record}/edit'),
        ];
    }
}
