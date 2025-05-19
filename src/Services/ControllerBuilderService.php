<?php

namespace Uzinfocom\Dastyor\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ControllerBuilderService extends AllGenerator {

    public function __construct() {
        $this->stab = 'controller.stub';
        $this->group = "Controller.php";
    }

    public function generate(array $model, string $name, string $namespace): void {
        /* @var Model $entity */
        // Read boilerplate from storage
        $stub = $this->getStub();

        // Model
        $modelName = $model['name'];
        $modelNamePlural = Str::plural(Str::lcfirst($modelName));
        $modelNameSingular = Str::lcfirst($modelName);
        $modelResourceName = Str::lower(preg_replace('/([a-z])([A-Z])/', '$1-$2', Str::plural($modelName)));

        $content = str_replace([
            '{{ namespace }}',
            '{{ name }}',
            '{{ modelName }}',
            '{{ modelNamePlural }}',
            '{{ modelNameSingular }}',
            '{{ modelResourceName }}',
        ], [
            $namespace,
            $name,
            $modelName,
            $modelNamePlural,
            $modelNameSingular,
            $modelResourceName,
        ], $stub);

        // Make a director if it does not exist
        $location = $this->resolvePath($namespace);

        // Make ready boilerplate as Service $namespace/$name
        $this->make($location, $name, $content);
    }
}
