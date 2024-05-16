<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FixedBillResource\Pages;
use App\Filament\Resources\FixedBillResource\RelationManagers;
use App\Models\FixedBill;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FixedBillResource extends Resource
{
    protected static ?string $model = FixedBill::class;

    protected static ?string $modelLabel = 'Contas Fixas - Parceladas';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';


    protected static ?string $navigationGroup = 'Contas';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('category_id')
                    ->label('Categoria')
                    ->relationship('category', 'name')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->createOptionForm([
                        TextInput::make('name')
                            ->label('Nome')
                            ->required(),
                    ]),
                TextInput::make('title')
                    ->label('Título')
                    ->required()
                    ->maxLength(255),
                TextInput::make('total_value')
                    ->label('Valor total')
                    ->prefix('R$')
                    ->required()
                    ->numeric(),
                TextInput::make('number_parcel')
                    ->label('Número de parcelas')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (Get $get, Set $set, $state) {
                        if (filled($state)) {
                            $repeaterItems = $get('parcelsItems');
                            $totalValue =  $get('total_value');
                            for ($i = 1; $i <= $state; $i++) {
                                array_push($repeaterItems, ['parcel_number' => $i, 'value' => $totalValue / $state]);
                            }
                            $set('parcelsItems', $repeaterItems);
                        }
                    }),
                Repeater::make('parcelsItems')
                    ->relationship()
                    ->defaultItems(0)
                    ->label('Parcelas')
                    ->schema([
                        TextInput::make('parcel_number')
                            ->label('Número da parcela')
                            ->required()
                            ->numeric(),
                        TextInput::make('value')
                            ->label('Valor')
                            ->prefix('R$')
                            ->required()
                            ->numeric(),
                        DatePicker::make('due_date')
                            ->native(false)
                            ->label('Data de vencimento')
                            ->required(),
                        Toggle::make('is_paid')
                            ->label('Pago')
                    ])->columnSpanFull()->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Título')
                    ->searchable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Categoria')
                    ->badge()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_value')
                    ->label('Valor total')
                    ->money('brl')
                    ->sortable(),
                Tables\Columns\TextColumn::make('number_parcel')
                    ->label('Número de parcelas')
                    ->numeric()
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
            ])->modifyQueryUsing(function (Builder $query) {
                $query->where('user_id', auth()->id());
            });
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
            'index' => Pages\ListFixedBills::route('/'),
            'create' => Pages\CreateFixedBill::route('/create'),
            'view' => Pages\ViewFixedBill::route('/{record}'),
            'edit' => Pages\EditFixedBill::route('/{record}/edit'),
        ];
    }
}
