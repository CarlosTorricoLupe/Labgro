<?php

namespace App\Strategies\SectionState;

use App\Strategies\SectionStateInterface;

class InLacteos implements SectionStateInterface {

    private static $SECTION_LACTEOS = "Producción Lácteos";
    private static $ROLE_ID = 2;

    public function getNameSectionState()
    {
        return self::$SECTION_LACTEOS;
    }

    public function getRoleSectionState()
    {
        return self::$ROLE_ID;

    }
}
