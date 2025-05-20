<?php

namespace Ijodkor\Dastyor\Services;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class AllGenerator {

    protected string $stab;
    protected string $list_stab;
    protected string $group;

    const STUB_PATH = "stubs";

    protected function make(string $location, string $name, string $content): void {
        $path = base_path(join("/", [$location, $name . $this->group]));
        File::put($path, $content);
    }

    protected function overwrite(string $location, string $content): void {
        $path = base_path(join("/", [$location . $this->group]));
        File::put($path, $content);
    }

    /* Additional methods */
    protected function root(string $path = ""): string {
        return __DIR__ . "/../../" . $path;
    }

    public function getStub(): string {
        return File::get($this->root(self::STUB_PATH . "/$this->stab"));
    }

    public function resolvePath(?string $namespace): string {
        $path = Str::camel(Str::replace('\\', '/', $namespace));

        // Make a directory
        $directory = base_path($path);
        if (!File::exists($directory)) {
            File::makeDirectory($directory, recursive: true);
        }

        return $path;
    }
}