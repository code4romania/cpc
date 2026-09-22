@props(['dataset'])

@php
    use App\Enums\ChartType;

    $points = $dataset->dataPoints;
    $slug = $dataset->slug;
    $type = $dataset->chart_type;
    $isPie = $type === ChartType::Pie;
    $isLine = $type === ChartType::Line;
    $isHorizontal = $slug === 'regional-distribution';
    $barColor = match ($slug) {
        'exploitation-types' => '#ef4444',
        'regional-distribution' => '#648baa',
        default => '#2a4c82',
    };
    $seriesColors = [
        'cases' => '#2a4c82',
        'victims' => '#648baa',
        'default' => '#2a4c82',
    ];
    $ceilings = [
        'cases-per-year' => 600,
        'regional-distribution' => 160,
        'exploitation-types' => 240,
        'monthly-trends' => 80,
    ];
    $maxValue = max(1, (float) $points->max('value'));
    $ceiling = ($ceilings[$slug] ?? $maxValue) >= $maxValue ? ($ceilings[$slug] ?? $maxValue) : $maxValue;
    $ticks = [0, 0.25, 0.5, 0.75, 1];
    $palette = ['#2a4c82', '#7950a4', '#648baa', '#242159'];
@endphp

@if ($points->isEmpty())
    <p class="text-sm text-muted">{{ __('statistics.none') }}</p>
@elseif ($isPie)
    @php
        $total = max(1, (float) $points->sum('value'));
        $showPercent = abs($total - 100) < 1;
        $cx = 180;
        $cy = 120;
        $radius = 72;
        $cursor = 0;
    @endphp
    <svg viewBox="0 0 360 250" class="w-full h-64" role="img">
        @foreach ($points->values() as $index => $point)
            @php
                $sweep = ($point->value / $total) * 360;
                $start = $cursor;
                $end = $cursor + $sweep;
                $cursor = $end;
                $startRad = deg2rad($start - 90);
                $endRad = deg2rad($end - 90);
                $x1 = $cx + ($radius * cos($startRad));
                $y1 = $cy + ($radius * sin($startRad));
                $x2 = $cx + ($radius * cos($endRad));
                $y2 = $cy + ($radius * sin($endRad));
                $large = $sweep > 180 ? 1 : 0;
                $mid = deg2rad((($start + $end) / 2) - 90);
                $labelX = $cx + (($radius + 38) * cos($mid));
                $labelY = $cy + (($radius + 38) * sin($mid));
                $color = $point->metadata['color'] ?? $palette[$index % count($palette)];
                $label = $point->label.': '.($showPercent ? (int) $point->value.'%' : number_format($point->value));
            @endphp
            <path d="M {{ $cx }} {{ $cy }} L {{ $x1 }} {{ $y1 }} A {{ $radius }} {{ $radius }} 0 {{ $large }} 1 {{ $x2 }} {{ $y2 }} Z" fill="{{ $color }}"></path>
            <text x="{{ $labelX }}" y="{{ $labelY }}" text-anchor="middle" dominant-baseline="middle" fill="#648baa" font-size="12">{{ $label }}</text>
        @endforeach
    </svg>
@elseif ($isHorizontal)
    @php
        $width = 680;
        $rowHeight = 32;
        $height = 28 + ($points->count() * $rowHeight);
        $labelWidth = 176;
        $plotLeft = $labelWidth;
        $plotWidth = $width - $plotLeft - 16;
    @endphp
    <svg viewBox="0 0 {{ $width }} {{ $height }}" class="w-full" role="img">
        @foreach ($ticks as $tick)
            @php $x = $plotLeft + ($plotWidth * $tick); @endphp
            <line x1="{{ $x }}" y1="8" x2="{{ $x }}" y2="{{ $height - 24 }}" stroke="#e5e7eb" stroke-dasharray="3 3"></line>
            <text x="{{ $x }}" y="{{ $height - 8 }}" text-anchor="middle" fill="#666" font-size="12">{{ (int) round($ceiling * $tick) }}</text>
        @endforeach
        @foreach ($points->values() as $index => $point)
            @php
                $y = 12 + ($index * $rowHeight);
                $barWidth = ($point->value / $ceiling) * $plotWidth;
            @endphp
            <text x="{{ $labelWidth - 8 }}" y="{{ $y + 14 }}" text-anchor="end" fill="#666" font-size="12">{{ $point->label }}</text>
            <rect x="{{ $plotLeft }}" y="{{ $y }}" width="{{ max(2, $barWidth) }}" height="18" rx="2" fill="{{ $barColor }}"></rect>
        @endforeach
    </svg>
@else
    @php
        $width = 640;
        $height = $slug === 'exploitation-types' ? 340 : 280;
        $plotLeft = 44;
        $plotRight = 12;
        $plotTop = 12;
        $plotBottom = $slug === 'exploitation-types' ? 110 : 52;
        $plotWidth = $width - $plotLeft - $plotRight;
        $plotHeight = $height - $plotTop - $plotBottom;
        $series = $isLine
            ? $points->groupBy(fn ($point) => $point->group_key ?? 'default')
            : collect(['default' => $points]);
        $categories = $series->first()?->values() ?? collect();
        $count = max(1, $categories->count());
    @endphp
    <svg viewBox="0 0 {{ $width }} {{ $height }}" class="w-full h-72" role="img">
        @foreach ($ticks as $tick)
            @php
                $y = $plotTop + ($plotHeight * (1 - $tick));
            @endphp
            <line x1="{{ $plotLeft }}" y1="{{ $y }}" x2="{{ $width - $plotRight }}" y2="{{ $y }}" stroke="#e5e7eb" stroke-dasharray="3 3"></line>
            <text x="{{ $plotLeft - 8 }}" y="{{ $y + 4 }}" text-anchor="end" fill="#666" font-size="12">{{ (int) round($ceiling * $tick) }}</text>
        @endforeach

        @if ($isLine)
            @foreach ($series as $key => $seriesPoints)
                @php
                    $coords = $seriesPoints->values()->map(function ($point, $index) use ($count, $plotLeft, $plotWidth, $plotTop, $plotHeight, $ceiling) {
                        $x = $plotLeft + (($index + 0.5) * ($plotWidth / $count));
                        $y = $plotTop + $plotHeight - (($point->value / $ceiling) * $plotHeight);

                        return [$x, $y];
                    });
                    $color = $seriesColors[$key] ?? '#2a4c82';
                @endphp
                <polyline fill="none" stroke="{{ $color }}" stroke-width="2" points="{{ $coords->map(fn ($pair) => $pair[0].','.$pair[1])->implode(' ') }}"></polyline>
                @foreach ($coords as $pair)
                    <circle cx="{{ $pair[0] }}" cy="{{ $pair[1] }}" r="3.5" fill="{{ $color }}"></circle>
                @endforeach
            @endforeach
            @foreach ($categories as $index => $point)
                @php $x = $plotLeft + (($index + 0.5) * ($plotWidth / $count)); @endphp
                <text x="{{ $x }}" y="{{ $height - $plotBottom + 20 }}" text-anchor="middle" fill="#666" font-size="12">{{ $point->label }}</text>
            @endforeach
        @else
            @foreach ($categories as $index => $point)
                @php
                    $slot = $plotWidth / $count;
                    $barWidth = $slot * 0.62;
                    $x = $plotLeft + ($index * $slot) + (($slot - $barWidth) / 2);
                    $barHeight = ($point->value / $ceiling) * $plotHeight;
                    $y = $plotTop + $plotHeight - $barHeight;
                    $labelX = $x + ($barWidth / 2);
                    $labelY = $height - 16;
                @endphp
                <rect x="{{ $x }}" y="{{ $y }}" width="{{ $barWidth }}" height="{{ max(2, $barHeight) }}" fill="{{ $barColor }}"></rect>
                @if ($slug === 'exploitation-types')
                    <text x="{{ $labelX }}" y="{{ $plotTop + $plotHeight + 8 }}" text-anchor="end" fill="#666" font-size="11" transform="rotate(-40 {{ $labelX }} {{ $plotTop + $plotHeight + 8 }})">{{ $point->label }}</text>
                @else
                    <text x="{{ $labelX }}" y="{{ $labelY }}" text-anchor="middle" fill="#666" font-size="12">{{ $point->label }}</text>
                @endif
            @endforeach
        @endif
    </svg>

    @if ($slug === 'cases-per-year' || $isLine)
        <div class="mt-2 flex flex-wrap justify-center gap-4 text-sm text-muted">
            @if ($isLine)
                @foreach ($series as $key => $seriesPoints)
                    <span class="inline-flex items-center gap-2">
                        <span class="h-0.5 w-6" style="background-color: {{ $seriesColors[$key] ?? '#2a4c82' }}"></span>
                        {{ __('statistics.series.'.($key === 'default' ? 'reported' : $key)) }}
                    </span>
                @endforeach
            @else
                <span class="inline-flex items-center gap-2">
                    <span class="h-3 w-3" style="background-color: {{ $barColor }}"></span>
                    {{ __('statistics.series.reported') }}
                </span>
            @endif
        </div>
    @endif
@endif
