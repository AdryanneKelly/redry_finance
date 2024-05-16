<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GeneralBalanceResource\Pages;
use App\Filament\Resources\GeneralBalanceResource\RelationManagers;
use App\Models\GeneralBalance;
use App\Models\RecurringBill;
use App\Models\VariantBill;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\DB;

class GeneralBalanceResource extends Resource
{
    protected static ?string $model = GeneralBalance::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $modelLabel = 'Saldo geral';
    protected static ?string $pluralModelLabel = 'Saldos gerais';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(3)->schema([
                    Forms\Components\DatePicker::make('related_month')->label('Mês referente')
                        ->native(false)
                        ->displayFormat('F/Y')
                        ->required(),
                    Forms\Components\TextInput::make('balance')
                        ->label('Saldo')
                        ->prefix('R$')
                        ->required()
                        ->live()
                        ->disabled()
                        ->dehydrated()
                        ->default(0.00),
                    TextInput::make('available_balance')
                        ->label('Saldo disponível')
                        ->readOnly()
                        ->prefix('R$')
                        ->numeric()
                        ->default(0.00),
                ]),
                TextInput::make('fixed_bills_total')
                    ->label('Total de contas fixas')
                    ->prefix('R$')
                    ->numeric()
                    ->lazy()
                    ->readOnly()
                    ->default(0.00),
                TextInput::make('recurring_bills_total')
                    ->label('Total de contas recorrentes')
                    ->prefix('R$')
                    ->lazy()
                    ->readOnly()
                    ->default(0.00),
                TextInput::make('variant_bills_total')
                    ->label('Total de contas variantes')
                    ->prefix('R$')
                    ->readOnly()
                    ->numeric()
                    ->lazy()
                    ->default(0.00),
                TextInput::make('total_bills')
                    ->label('Total de contas')
                    ->prefix('R$')
                    ->numeric()
                    ->readOnly()
                    ->default(0.00),
                Repeater::make('entries')
                    ->label('Lançamentos')->columnSpanFull()->grid()
                    ->columns(2)
                    ->relationship()
                    ->schema([
                        TextInput::make('description')
                            ->label('Descrição')
                            ->required(),
                        TextInput::make('value')
                            ->label('Valor')
                            ->prefix('R$')
                            ->numeric()
                            ->lazy()
                            ->required(),
                        Forms\Components\DatePicker::make('entry_date')->label('Data')
                            ->native(false)
                            ->displayFormat('d/m/Y')
                            ->required(),
                    ]),
                Placeholder::make('.')
                    ->content(function (Get $get, Set $set) {
                        if ($get('entries') != null) {
                            $total = 0;
                            foreach ($get('entries') as $entry) {
                                $total += doubleval($entry['value']);
                            }
                            $set('balance',  $total);
                        }

                        $recurring = static::recurringBillTotal();
                        $set('recurring_bills_total', $recurring);

                        $variant_total = static::variantBillTotal();
                        $set('variant_bills_total', $variant_total);

                        $fixed_total = static::fixedBillsTotal();
                        $set('fixed_bills_total', $fixed_total);

                        $total_bills = $recurring + $variant_total + $fixed_total;
                        $set('total_bills', $total_bills);

                        $available_balance = $get('balance') - $total_bills;
                        $set('available_balance', $available_balance);
                    }),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('related_month')
                    ->label('Mês referente')
                    ->date('F/Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('balance')
                    ->label('Saldo')
                    ->money('brl')
                    ->sortable(),
                Tables\Columns\TextColumn::make('available_balance')
                    ->label('Saldo disponível')
                    ->money('brl')
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
            'index' => Pages\ListGeneralBalances::route('/'),
            'create' => Pages\CreateGeneralBalance::route('/create'),
            'view' => Pages\ViewGeneralBalance::route('/{record}'),
            'edit' => Pages\EditGeneralBalance::route('/{record}/edit'),
        ];
    }

    public static function recurringBillTotal()
    {
        $recurring = RecurringBill::where('user_id', auth()->id())
            ->where('is_active', true)
            ->get();
        $recurring_total = 0;
        foreach ($recurring as $bill) {
            $recurring_total += $bill->value;
        }

        return $recurring_total;
    }

    public static function variantBillTotal()
    {
        $variant = VariantBill::where('user_id', auth()->id())
            ->whereBetween('purchase_date', [
                now()->startOfMonth(),
                now()->endOfMonth(),
            ])
            ->get();
        $variant_total = 0;
        foreach ($variant as $bill) {
            $variant_total += $bill->value;
        }

        return $variant_total;
    }

    public static function fixedBillsTotal()
    {
        $fixedBills = DB::table('fixed_bill_items')
            ->join('fixed_bills', 'fixed_bill_items.fixed_bill_id', '=', 'fixed_bills.id')
            ->where('fixed_bills.user_id', auth()->id())
            ->whereBetween('fixed_bill_items.due_date', [
                now()->startOfMonth(),
                now()->endOfMonth(),
            ])
            ->get();
        $fixed_total = 0;

        foreach ($fixedBills as $bill) {
            $fixed_total += $bill->value;
        }

        return $fixed_total;
    }
}
