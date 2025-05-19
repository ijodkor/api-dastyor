<?php

namespace Uzinfocom\Dastyor\Livewire;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Attributes\Validate;
use Uzinfocom\Dastyor\Boot\Boot;
use Uzinfocom\Dastyor\Models\ColumnType;
use Uzinfocom\Dastyor\Services\Migration\MigrationBuildService;
use Uzinfocom\Dastyor\Shared\Utils\EntityFinderService;
use Uzinfocom\Dastyor\Shared\Utils\TableFinderService;


class MigrationWire extends GeneratorWire {

    public array $meta = [
        'description' => "Jadval yaratuvchi",
        'route' => "migrations.store"
    ];

    public string $prefix = "database\migrations\\";

    public string $namespace = "database\migrations";

    #[Validate('required|min:4')]
    public $name = '';

    #[Validate('boolean')]
    public $softDelete = false;

    #[Validate([
        'columns.*.name' => 'required|string',
        'columns.*.type' => 'required|string',
        'columns.*.default' => 'nullable',
        'columns.*.index' => 'required|boolean',
        'columns.*.nullable' => 'required|boolean',
        'columns.*.length' => 'nullable',
        'columns.*.constrained' => 'nullable'
    ])]
    public Collection $columns;

    public Collection $types;
    public Collection $tables;
    public Collection $schemas;

    public function __construct() {
        $this->columns = collect();
        $this->types = collect();
    }

    public function boot(EntityFinderService $modelFinder, TableFinderService $tableFinder = null): void {
        // Tables
        $this->schemas = $tableFinder->getSchemas();
        $this->tables = $tableFinder->getTables();

        // Types
        $types = Boot::getFromJson(Boot::getDatabase("data-types.json"));
        $this->types = collect();
        foreach ($types as $type) {
            $this->types->push(new ColumnType($type));
        }
    }

    /*** Custom methods ***/
    public function addColumn(): void {
        $this->columns->push([
            "name" => null,
            "type" => null,
            "length" => null,
            "default" => null,
            "nullable" => false,
            "index" => false,
            "unsigned" => false,
            "autoIncrement" => false,
        ]);
    }

    public function save(MigrationBuildService $service): void {
        $this->validate();

        $service->create([
            'name' => $this->name,
            "softDelete" => $this->softDelete,
            'namespace' => $this->namespace,
            'columns' => $this->columns->toArray()
        ]);

        session()->flash('success', 'Jadval muvaffaqiyatli yaratildi!');
    }

    public function remove(int $key): void {
        $this->columns->pull($key);
    }

    public function render(): View {
        $columns = $this->columns;
        $tables = $this->tables;

        return view(Boot::getView('livewire.migration'), compact('columns', 'tables'));
    }
}
