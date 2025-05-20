<?php

namespace Ijodkor\Dastyor\Services;

use Ijodkor\ApiResponse\Responses\RestResponse;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

class RequestBuilderService extends AllGenerator {
    use RestResponse;

    public function __construct() {
        $this->stab = 'request.stub';
        $this->group = "Request.php";
        $this->list_stab = 'list-request.stub';
    }

    public function generateCreate(array $model, string $name, string $namespace): void {
        /* @var Model $entity */
        // Read boilerplate from storage
        $stub = $this->getStub();

        // Model
        $modelNamespace = $model['namespace'];
        $entity = new $modelNamespace();

        $columns = $this->getTableColumns($entity->getTable());
        $rules = $this->generateValidationRules($columns);

        $name .= "Create";
        $content = str_replace([
            '{{ namespace }}',
            '{{ name }}',
            '{{ rules }}',
        ], [
            $namespace,
            $name,
            $rules
        ], $stub);

        // Make a director if it does not exist
        $location = $this->resolvePath($namespace);

        // Make ready boilerplate as Service $namespace/$name
        $this->make($location, $name, $content);
    }

    public function generateList(array $model, string $name, string $namespace): void {
        /* @var Model $entity */
        // Read boilerplate from storage
        $stub = $this->getListStub();

        // Model
        $modelNamespace = $model['namespace'];
        $entity = new $modelNamespace();

        $columns = $this->getTableColumns($entity->getTable());
        $rules = $this->generateValidationRules($columns);

        $content = str_replace([
            '{{ namespace }}',
            '{{ name }}',
            '{{ rules }}',
        ], [
            $namespace,
            $name,
            $rules
        ], $stub);

        // Make a director if it does not exist
        $location = $this->resolvePath($namespace);

        // Make ready boilerplate as Service $namespace/$name
        $this->make($location, $name, $content);
    }

    public function generateUpdate(array $model, string $name, string $namespace): void {
        /* @var Model $entity */
        // Read boilerplate from storage
        $stub = $this->getStub();

        // Model
        $modelNamespace = $model['namespace'];
        $entity = new $modelNamespace();

        $columns = $this->getTableColumns($entity->getTable());
        $rules = $this->generateValidationRules($columns);

        $name .= "Update";
        $content = str_replace([
            '{{ namespace }}',
            '{{ name }}',
            '{{ rules }}',
        ], [
            $namespace,
            $name,
            $rules
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

    protected function generateValidationRules($columns): string {
        $columns = array_keys($columns);
        $columns = array_diff($columns, ['id', 'created_at', 'updated_at', 'deleted_at']);
        $rules = [];
        foreach ($columns as $column) {
            $rules[] = "'{$column}' => 'required'";
        }
        return implode(",\n            ", $rules);
    }

    public function getListStub(): string {
        return File::get($this->root(self::STUB_PATH . "/$this->list_stab"));
    }
}
