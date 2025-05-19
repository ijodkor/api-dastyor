<?php

namespace Ijodkor\Dastyor\Services;

use Exception;
use Illuminate\Support\Str;

class GenerateEnum extends AllGenerator {

    public function __construct() {
        $this->stab = 'enum.stub';
        $this->group = "Enum.php";
    }

    /**
     * @throws Exception
     */
    public function generate(string $namespace, string $name, $type, array $variables): void {
        $stub = $this->getStub();
        $data = $this->generateVariables($variables);
        $content = str_replace([
            '{{ namespace }}',
            '{{ name }}',
            '{{ type }}',
            '{{ variables }}',
        ], [
            $namespace,
            $name,
            $type,
            $data,
        ], $stub);

        $location = $this->resolvePath($namespace);

        $this->make($location, $name, $content);
    }

    private function generateVariables($attributes): string {
        $variables = [];
        foreach ($attributes as $attribute) {
            $variables[] = "case " . Str::upper($attribute['key']) . " = " . $attribute['value'] . ';';
        }
        return implode("\n\t", $variables);
    }
}
