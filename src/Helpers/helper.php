<?php

if (!function_exists('getModelName')) {
    function getModelName(string $path) {
        $path = explode('\\', $path);
        return end($path);
    }
}
