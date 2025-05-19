<?php

namespace Uzinfocom\Dastyor\Services;

use Illuminate\Support\Facades\File;
use Uzinfocom\Dastyor\Helpers\StorageManager;

class AllGenerator {
    use StorageManager;

    protected string $stab;
    protected string $list_stab;
    protected string $group;

    protected function make(string $location, string $name, string $content): void {
        $path = base_path(join("/", [$location, $name . $this->group]));
        File::put($path, $content);
    }

    protected function overwrite(string $location, string $content): void {
        $path = base_path(join("/", [$location . $this->group]));
        File::put($path, $content);
    }
}