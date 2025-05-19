<?php

namespace Uzinfocom\Dastyor\Shared\Utils;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use ReflectionClass;
use ReflectionException;
use SplFileInfo;

class EntityFinderService {
    public const NECESSARY_FILE = "php";
    public const APP = "App\\";

    function scan(string $directory): array {
        /**
         * @var SplFileInfo $file
         */
        $files = [];
        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));

        foreach ($iterator as $file) {
            if (!$file->isFile()) {
                continue;
            }

            if ($file->getExtension() === self::NECESSARY_FILE) {
                $files[] = $file->getPathname();
            }
        }

        return $files;
    }

    /**
     * Retrieve models
     */
    function getModels(string $directory): array {
        return $this->getDeclaredClasses($directory, Model::class);
    }

    function getControllers(string $directory): array {
        return $this->getDeclaredClasses($directory, "App\Http\Controllers\Controller");
    }

    public function getDeclaredClasses(string $directory, string $className): array {
        $instances = [];
        $files = $this->scan($directory);

        // Require all file that php can identify as file
        foreach ($files as $file) {
            require_once $file;
        }

        $classes = get_declared_classes();
        foreach ($classes as $class) {
            $isSubClass = is_subclass_of($class, $className);
            try {
                $isAbstract = (new ReflectionClass($class))->isAbstract();

                if ($isSubClass && !$isAbstract && Str::startsWith($class, self::APP)) {
                    $instances[] = $class;
                }
            } catch (ReflectionException) {

            }
        }

        return array_unique($instances);
    }
}
