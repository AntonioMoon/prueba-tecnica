<?php

namespace App\Filament\Widgets;

use App\Models\Country;
use Filament\Widgets\ChartWidget;

class TopPopulations extends ChartWidget
{
    protected static ?string $heading = 'Los 5 países principales por población';

    protected function getData(): array
    {
        $data = Country::orderBy('population', 'desc')
            ->take(5)
            ->pluck('population', 'name_common')
            ->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Population',
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
