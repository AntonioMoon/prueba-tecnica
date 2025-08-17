<?php

namespace App\Filament\Widgets;

use App\Models\Country;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class CountriesByRegion extends ChartWidget
{
    protected static ?string $heading = 'Países por región';

    protected function getData(): array
    {
        $data = Country::select('region', DB::raw('COUNT(*) as count'))
            ->groupBy('region')
            ->pluck('count', 'region')
            ->filter()
            ->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Countries',
                    'data' => array_values($data),
                ],
            ],
            'labels' => array_keys($data),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
