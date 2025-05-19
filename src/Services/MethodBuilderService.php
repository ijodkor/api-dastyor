<?php

namespace Ijodkor\Dastyor\Services;

use Exception;
use Illuminate\Support\Facades\File;

class MethodBuilderService extends AllGenerator {

    public function __construct() {
        $this->stab = 'method.stub';
        $this->group = ".php";
    }

    /**
     * @throws Exception
     */
    public function generate(string $namespace, string $name): void {
        $stub = $this->getStub();
        $content = str_replace([
            '{{ methodName }}',
        ], [
            $name,
        ], $stub);

        $location = $this->resolvePath($namespace);
        $array = file(base_path($location . $this->group));

        array_splice($array, array_key_last($array), 0, $content);

        $content = implode("", $array);
        $this->overwrite($location, $content);
    }
}
