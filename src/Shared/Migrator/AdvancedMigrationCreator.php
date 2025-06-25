<?php

namespace Ijodkor\Dastyor\Shared\Migrator;

use Illuminate\Database\Migrations\MigrationCreator;

class AdvancedMigrationCreator extends MigrationCreator {

    public function getExtendedPath($name): string {
        return $this->getPath("create_" . $name . "_table", '');
    }
}