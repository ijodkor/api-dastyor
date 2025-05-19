<?php

namespace Uzinfocom\Dastyor\Services\Migration;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Arr;
use Uzinfocom\Dastyor\Services\AllGenerator;
use Uzinfocom\Dastyor\Shared\Migrator\AdvancedMigrationCreator;

class MigrationBuildService extends AllGenerator {

    private readonly AdvancedMigrationCreator $creator;

    public function __construct() {
        $this->stab = 'migrations/migration.stub';
        $this->group = "";

        $this->creator = new AdvancedMigrationCreator(new Filesystem(), '');
    }

    public function create(array $data): void {
        // Read boilerplate from storage
        $boilerplate = $this->getStub();

        // Model
        $name = $data['name'];
        $namespace = $data['namespace'];

        // Columns
        $columns = $this->getColumns($data['columns'], Arr::get($data, 'softDelete'));

        $content = str_replace([
            '{{ tableName }}',
            '{{ columns }}'
        ], [
            $name,
            $columns
        ], $boilerplate);

        // Make a director if it does not exist
        $location = $this->resolvePath($namespace);

        // Make ready boilerplate as Service $namespace/$name
        $this->make($location, $this->creator->getExtendedPath($name), $content);
    }

    private function getColumns(array $columns, $softDelete): string {
        $columnDefinitions = [];
        $extras = [];

        if ($softDelete) {
            $columns[] = [
                'type' => "softDeletes",
                'name' => ""
            ];
        }

        foreach ($columns as $column) {
            // Append length for string types
            $definitions = [
                $column['type'],
                $column['name']
            ];

            if (Arr::get($column, 'length')) {
                $this->stab = "migrations/column.limited.stub";
                $definitions[] = Arr::get($column, 'length');
            }

            if ($column['type'] == 'softDeletes') {
                $this->stab = "migrations/column.soft-delete.stub";
            }

            if (!isset($column['length']) && $column['type'] != 'softDeletes') {
                $this->stab = "migrations/column.stub";
            }

            $boilerplate = $this->getStub();

            // Build the column definition
            $columnDefinition = str_replace([
                '{{ columnType }}',
                '{{ columnName }}',
                '{{ columnLength }}'
            ], $definitions, $boilerplate);

            $this->getExtras($column, $extras);

            $columnDefinition = str_replace([
                '{{ extra }}',
            ], implode('', $extras), $columnDefinition);

            // Collect the column definitions
            $columnDefinitions[] = $columnDefinition;
        }

        // Combine all column definitions into a single string with desired formatting
        return rtrim(implode('', $columnDefinitions));
    }

    private function getExtras($column, &$extras): void {
        $extras = [];
        // Append default value if provided
        if (Arr::get($column, 'default')) {
            $extras[] = "->default('{$column['default']}')";
        }

        // Add index
        if (Arr::get($column, 'index')) {
            $extras[] = '->index()';
        }

        // Add nullable
        if (Arr::get($column, 'nullable')) {
            $extras[] = '->nullable()';
        }

        if (Arr::get($column, 'constrained')) {
            $this->stab = "migrations/column.related.stub";
            $boilerplate = $this->getStub();
            $extras[] = str_replace("{{ tableName }}", $column['constrained'], $boilerplate);
        }
    }
}