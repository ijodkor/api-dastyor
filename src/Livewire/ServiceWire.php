<?php

namespace Ijodkor\Dastyor\Livewire;

class ServiceWire extends BuilderWire {

    // Props
    public array $meta = [
        'description' => "Servis yaratuvchi",
        'route' => "services.store"
    ];

    public string $prefix = "App\Services\\";
    public string $namespace = "App\Services";
}
