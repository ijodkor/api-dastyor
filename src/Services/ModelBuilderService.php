<?php

namespace Uzinfocom\Dastyor\Services;

use Illuminate\Support\Facades\Schema;

class ModelBuilderService extends AllGenerator {

    public function __construct() {
        $this->stab = 'model.stub';
        $this->group = ".php";
    }

    public function generate(array $table, string $name, string $namespace): void {
        $columns = $this->getTableColumns($table['name']);
        // Annotated properties
        $properties = $this->getProperties($columns);
        // Fillable fields
        $attributes = $this->getAttributes($columns);

        // Read boilerplate from storage
        $stub = $this->getStub();
        $content = str_replace([
            '{{ model }}',
            '{{ namespace }}',
            '{{ properties }}',
            '{{ attributes }}'
        ], [
            $name,
            $namespace,
            $properties,
            $attributes
        ], $stub);

        // Make a director if it does not exist
        $location = $this->resolvePath($namespace);

        // Make ready boilerplate as Service $namespace/$name
        $this->make($location, $name, $content);
    }

    protected function getTableColumns($table): array {
        $columns = Schema::getColumnListing($table);
        $columnDetails = [];

        foreach ($columns as $column) {
            $columnDetails[$column] = Schema::getColumnType($table, $column);
        }

        return $columnDetails;
    }

    protected function getProperties($columns): string {
        $annotations = [];
        foreach ($columns as $column => $type) {
            $annotations[] = " * @property \${$column}";
        }
        return implode("\n", $annotations);
    }

    protected function getAttributes($columns): string {
        $fillable = array_keys($columns);
        $fillable = array_diff($fillable, ['id', 'created_at', 'updated_at', 'deleted_at']);
        return "['" . implode("', '", $fillable) . "']";
    }
}
