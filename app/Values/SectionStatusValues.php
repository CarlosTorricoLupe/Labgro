<?php

namespace App\Values;

use App\Strategies\SectionState\InCarnicos;
use App\Strategies\SectionState\InFrutas;
use App\Strategies\SectionState\InLacteos;

final class SectionStatusValues
{
    const STRATEGY = [
        'Producción Cárnicos' => InCarnicos::class,
        'Producción Lácteos' => InLacteos::class,
        'Producción Frutas' => InFrutas::class,
    ];
}
