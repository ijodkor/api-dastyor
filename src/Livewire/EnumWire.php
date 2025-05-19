<?php

namespace Uzinfocom\Dastyor\Livewire;

use Illuminate\Contracts\View\View;
use Uzinfocom\Dastyor\Boot\Boot;

class EnumWire extends GeneratorWire {

    public array $meta = [
        'description' => "Enum yaratuvchi",
        'route' => "enums.store"
    ];

    public string $prefix = "App\Enums\\";
    public string $namespace = "App\Enums";


    public function render(): View {
        return view(Boot::getView('livewire.enum-wire'));
    }
}
