<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CountryResource\Pages;
use App\Models\Country;
use Filament\Resources\Resource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;


class CountryResource extends Resource
{
    protected static ?string $model = Country::class;
    protected static ?string $navigationIcon = 'heroicon-o-globe-alt';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('cca3')
                    ->required()
                    ->length(3)
                    ->unique(Country::class, 'cca3', ignoreRecord: true),
                Forms\Components\TextInput::make('name_common')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('name_official')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('region')
                    ->maxLength(255),
                Forms\Components\TextInput::make('subregion')
                    ->maxLength(255),
                Forms\Components\TextInput::make('capital')
                    ->maxLength(255),
                self::numericInput('population'),
                self::numericInput('area'),
                Forms\Components\TextInput::make('flag_emoji')
                    ->maxLength(10),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('cca3')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('name_common')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('region')
                    ->sortable(),
                Tables\Columns\TextColumn::make('population')
                    ->sortable()
                    ->formatStateUsing(fn($state) => number_format($state)),
                Tables\Columns\TextColumn::make('flag_emoji'),
            ])
            ->filters([
                SelectFilter::make('region')
                    ->options(fn() => Country::distinct()->pluck('region', 'region')->filter()->toArray()),
                Filter::make('population')
                    ->form([
                        Forms\Components\TextInput::make('population_min')
                            ->numeric()
                            ->minValue(0),
                        Forms\Components\TextInput::make('population_max')
                            ->numeric()
                            ->minValue(0),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['population_min'], fn($q) => $q->where('population', '>=', $data['population_min']))
                            ->when($data['population_max'], fn($q) => $q->where('population', '<=', $data['population_max']));
                    }),
                Filter::make('cca3')
                    ->form([
                        Forms\Components\TextInput::make('cca3')
                            ->label('Codigo Pais (CCA3)')
                            ->placeholder('CCA3  (ejemplo., TUN)'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when($data['cca3'], fn($q) => $q->where('cca3', 'like', '%' . $data['cca3'] . '%'));
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCountries::route('/'),
            'create' => Pages\CreateCountry::route('/create'),
            'edit' => Pages\EditCountry::route('/{record}/edit'),
        ];
    }

    private static function numericInput(string $name): Forms\Components\TextInput
    {
        return Forms\Components\TextInput::make($name)
            ->numeric()
            ->minValue(0)
            ->required()
            ->formatStateUsing(fn($state) => $state ? number_format($state) : null)
            ->dehydrateStateUsing(fn($state) => str_replace(',', '', $state));
    }
}
