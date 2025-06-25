<?php

namespace Ijodkor\Dastyor\Livewire;

use Ijodkor\Dastyor\Boot\Boot;
use Ijodkor\Dastyor\Shared\Utils\EntityFinderService;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class MethodWire extends BuilderWire {

    public string $namespace;

    public array $meta = [
        'description' => "Kontrollerga method yaratuvchi",
        'route' => "methods.store"
    ];

    private readonly Collection $controllers;

    public function boot(EntityFinderService $modelFinder): void {
        $this->controllers = $this->getControllers($modelFinder);
    }

    public function render(): View {
        $controllers = $this->controllers;
        return view(Boot::getView('livewire.method-wire'), compact('controllers'));
    }

    public function getControllers(EntityFinderService $controllerFinder): Collection {
        return collect($controllerFinder->getControllers(app_path()))->map(function($controller) {
            return (object)[
                'name' => Str::afterLast($controller, "\\"),
                'namespace' => $controller
            ];
        });
    }
}
