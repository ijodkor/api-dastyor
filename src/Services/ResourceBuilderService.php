<?php

namespace Uzinfocom\Dastyor\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class ResourceBuilderService extends AllGenerator {

    public function __construct() {
        $this->stab = 'resource.stub';
        $this->group = "Resource.php";
    }

    public function generate(array $model, string $name, ?string $namespace): void {
        /* @var Model $entity */
        // Read boilerplate from storage
        $stub = $this->getStub();

        // Model
        $modelName = $model['name'];
        $modelNamespace = $model['namespace'];
        $entity = new $modelNamespace();

        $columns = $this->getTableColumns($entity->getTable());
        $fields = $this->generateResourceFields($columns);

        $content = str_replace([
            '{{ namespace }}',
            '{{ name }}',
            '{{ modelNamespace }}',
            '{{ modelName }}',
            '{{ fields }}',
        ], [
            $namespace,
            $name,
            $modelNamespace,
            $modelName,
            $fields
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

    protected function generateResourceFields($columns): string {
        $columns = array_keys($columns);
        $columns = array_diff($columns, ['created_at', 'updated_at', 'deleted_at']);
        $fields = [];
        foreach ($columns as $column) {
            $fields[] = "'{$column}' => \$this->{$column}";
        }
        return implode(",\n            ", $fields);
    }
}
