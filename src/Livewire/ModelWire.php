<?php

namespace Ijodkor\Dastyor\Livewire;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Ijodkor\Dastyor\Boot\Boot;
use Ijodkor\Dastyor\Shared\Utils\EntityFinderService;
use Ijodkor\Dastyor\Shared\Utils\TableFinderService;

class ModelWire extends BuilderWire {

    public string $tableName;
    public string $name;
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
            $this->name = "";
            return;
        }

        $migration = Str::replace('_', ' ', $this->tableName);
        $string = Str::replace(' ', '', ucwords($migration));
        $this->name = Str::singular($string);
    }

    public function render(): View {
        $tables = $this->tables;
        return view(Boot::getView('livewire.model-wire'), compact('tables'));
    }
}
