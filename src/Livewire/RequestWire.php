<?php

namespace Ijodkor\Dastyor\Livewire;

class RequestWire extends GeneratorWire {

    // Props
    public array $meta = [
            'description' => "Request yaratuvchi",
            'route' => "requests.store"
    ];

    public string $prefix = "App\Http\Requests\\";
    public string $namespace = "App\Http\Requests";
    protected string $view = "livewire.request-wire";
}
