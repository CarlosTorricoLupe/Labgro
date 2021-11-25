<?php

namespace App\Strategies\SectionState;

use App\Strategies\SectionStateInterface;

class InCarnicos implements SectionStateInterface {

    private static $SECTION_CARNICOS = "Producción Cárnicos";
    private static $ROLE_ID = 4;

    public function getNameSectionState()
    {
        return self::$SECTION_CARNICOS;
    }

    public function getRoleSectionState()
    {
        return self::$ROLE_ID;

    }
}
