<?php

namespace App\Enums;

enum ChartType: string
{
    case Bar = 'bar';
    case Line = 'line';
    case Pie = 'pie';
    case Area = 'area';

    public function label(): string
    {
        return __('enums.chart_type.' . $this->value);
    }
}
