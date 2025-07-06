<?php

namespace Ijodkor\Dastyor\Livewire;

class RequestWire extends BuilderWire {

    // Props
    public array $meta = [
        'description' => "So\u{2018}rov tutuvchi yaratuvchisi",
        'route' => "requests.store"
    ];

    public string $prefix = "App\Http\Requests\\";
    public string $namespace = "App\Http\Requests";
    protected string $view = "livewire.request-wire";
}
