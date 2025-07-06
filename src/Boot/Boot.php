<?php

namespace Ijodkor\Dastyor\Boot;


use Illuminate\Support\Facades\File;
use Illuminate\Support\HtmlString;

class Boot {
    public const ROOT = "generator";

    public static function getView(string $name): string {
        return self::ROOT . "::" . $name;
    }

    /**
     * name -> Print working directory
     * @param string $directory
     * @return string
     */
    public static function getPwd(string $directory): string {
        return __DIR__ . "/../../" . $directory;
    }

    public static function getDatabase(string $filename): string {
        return self::getPwd("database/$filename");
    }

    public static function getWire(string $wire): string {
        return $wire;
    }

    public static function getFromJson(string $filename) {
        $data = File::get($filename);
        return json_decode($data, true);
    }

    public static function css(): HtmlString {
        $files = [
            "css/tabler-icons.css",
            "css/core.css",
            "css/theme-default.css",
            "css/demo.css",
            "css/bs-stepper.css",
            "css/main.css",
        ];
        $styles = [];
        foreach ($files as $file) {
            $asset = asset('vendor/generator/assets/' . $file);
            $styles[] = "<link rel=\"stylesheet\" href=\"$asset\" />";
        }
        $styles = implode("\n", $styles);
        return new HtmlString($styles);
    }

    public static function js(): HtmlString {
        $files = [
            "js/jquery.js",
            "js/bootstrap.js",
            "js/bs-stepper.js",
        ];
        $scripts = [];
        foreach ($files as $file) {
            $scripts[] = "<script src='" . asset('vendor/generator/assets/' . $file) . "'>" . "</script>";
        }
        $scripts = implode("\n", $scripts);
        return new HtmlString($scripts);
    }
}