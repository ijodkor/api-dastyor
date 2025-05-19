<?php

namespace Ijodkor\Dastyor\Http\Controllers\Builders;

use Illuminate\Contracts\View\View;
use Ijodkor\Dastyor\Boot\Boot;
use Ijodkor\Dastyor\Http\Controllers\Controller;

class MigrationBuilderController extends Controller {
    public function __invoke(): View {
        return view(Boot::getView('migration.index'));
    }
}
