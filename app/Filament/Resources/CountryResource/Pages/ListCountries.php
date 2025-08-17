<?php

namespace App\Filament\Resources\CountryResource\Pages;

use App\Filament\Resources\CountryResource;
use Filament\Resources\Pages\ListRecords;

class ListCountries extends ListRecords
{
    protected static string $resource = CountryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\Action::make('updateFromApi')
                ->label('Sincronizar desde API')
                ->icon('heroicon-o-arrow-path')
                ->color('primary')
                ->requiresConfirmation()
                ->action(function () {
                    $service = app(\App\Services\CountryService::class);
                    $result = $service->updateFromApi();

                    \Filament\Notifications\Notification::make()
                        ->title('Sincronización Completada')
                        ->body("Creados: {$result['created']}, Actualizados: {$result['updated']}")
                        ->success()
                        ->send();
                }),

            \Filament\Actions\CreateAction::make()
                ->label('Crear País'),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            \App\Filament\Widgets\TopPopulations::class,
            \App\Filament\Widgets\CountriesByRegion::class,
        ];
    }
}
