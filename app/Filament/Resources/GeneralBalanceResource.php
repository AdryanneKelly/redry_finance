<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GeneralBalanceResource\Pages;
use App\Filament\Resources\GeneralBalanceResource\RelationManagers;
use App\Models\GeneralBalance;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

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
                Forms\Components\DatePicker::make('related_month')->label('Mês referente')
                    ->native(false)
                    ->displayFormat('F/Y')
                    ->required(),
                Forms\Components\TextInput::make('balance')
                    ->label('Saldo')
                    ->prefix('R$')
                    ->required()
                    ->numeric()
                    ->default(0.00),
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
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
}
