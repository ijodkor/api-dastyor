<?php

namespace Ijodkor\Dastyor\Livewire;

class ServiceWire extends GeneratorWire {

    // Props
    public array $meta = [
        'description' => "Servis yaratuvchi",
        'route' => "service.store"
    ];

    public string $prefix = "App\Services\\";
    public string $namespace = "App\Services";
}
