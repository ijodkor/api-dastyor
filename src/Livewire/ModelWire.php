<?php

namespace Uzinfocom\Dastyor\Livewire;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Uzinfocom\Dastyor\Boot\Boot;
use Uzinfocom\Dastyor\Shared\Utils\EntityFinderService;
use Uzinfocom\Dastyor\Shared\Utils\TableFinderService;

class ModelWire extends GeneratorWire {

    public string $tableName;
    public string $convertedName;
    public Collection $tables;

    public array $meta = [
        'description' => "Model yaratuvchi",
        'route' => "models.store"
    ];

    public function boot(EntityFinderService $modelFinder, TableFinderService $tableFinder = null): void {
        parent::boot($modelFinder);

        $this->tables = $tableFinder->getMigratedTables();
    }

    public string $prefix = "App\Models\\";
    public string $namespace = "App\Models";

    public function choose(): void {
        if (!isset($this->tableName)) {
            $this->convertedName = "";
            return;
        }

        $string = Str::replace('_', ' ', $this->tableName);
        $string = ucwords($string);
        $string = Str::replace(' ', '', $string);
        $this->convertedName = Str::singular($string);
    }

    public function render(): View {
        $tables = $this->tables;
        return view(Boot::getView('livewire.model-wire'), compact('tables'));
    }
}
