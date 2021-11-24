<?php

namespace App\Strategies\SectionState;

use App\Strategies\SectionStateInterface;

class InFrutas implements SectionStateInterface {

    private static $SECTION_FRUTAS = "Producción Frutas";
    private static $ROLE_ID = 5;

    public function getNameSectionState()
    {
        return self::$SECTION_FRUTAS;
    }

    public function getRoleSectionState()
    {
        return self::$ROLE_ID;

    }
}
