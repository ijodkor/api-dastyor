<?php

namespace Uzinfocom\Dastyor\Services;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class RouteBuilderService {
    public function generate(string $tableName, string $modelName): void {
        $stub = File::get(base_path('app/Generator/stubs/route.stub'));
        $modelNamePluralLower = Str::snake(Str::plural($tableName));
        $modelContent = str_replace(
            [
                '{{ modelName }}',
                '{{ modelNamePluralLower }}',
            ],
            [
                $modelName,
                $modelNamePluralLower,
            ], $stub);

        $path = base_path('routes/api.php');
        File::append($path, $modelContent);
    }
}
