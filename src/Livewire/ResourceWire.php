<?php

namespace Ijodkor\Dastyor\Livewire;

class ResourceWire extends GeneratorWire {

    // Props
    public array $meta = [
        'description' => "Resurs yaratuvchi",
        'route' => "resources.store"
    ];

    public string $prefix = "App\Http\Resources\\";
    public string $namespace = "App\Http\Resources";
}
