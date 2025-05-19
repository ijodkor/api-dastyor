<?php

namespace Ijodkor\Dastyor\Livewire;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Ijodkor\Dastyor\Boot\Boot;
use Ijodkor\Dastyor\Helpers\StorageManager;
use Ijodkor\Dastyor\Shared\Utils\EntityFinderService;

class ModelRelationWire extends GeneratorWire {
    use StorageManager;

    public string $namespace;
    public string $group = '.php';
    public array $meta = [
        'description' => "Model relationships"
    ];
    public array $relationships = [];
    public string $relationStub = 'model.relation.stub';
    public array $belongsToOptions = [
        ['key' => 'belongsTo', 'value' => 'Belongs to'],
        ['key' => 'belongsToMany', 'value' => 'Belongs to many']
    ];
    public array $hasManyOptions = [
        ['key' => 'hasMany', 'value' => 'Has many'],
        ['key' => 'hasOne', 'value' => 'Has one']
    ];
    const RELATION_TYPE_BELONGS = 'belongs';
    const RELATION_TYPE_HAS = 'has';
    protected readonly Collection $models;

    public function boot(EntityFinderService $modelFinder): void {
        $this->models = collect($modelFinder->getModels(app_path()))->map(function($model) {
            return (object)[
                'name' => Str::afterLast($model, "\\"),
                'namespace' => $model
            ];
        });
    }

    public function render(): View {
        $models = $this->models;
        return view(Boot::getView('livewire.model-relation-wire'), compact('models'));
    }

    public function selectModel(): void {
        $tableName = app()->make($this->namespace)->getTable();
        $this->relationships = [];

        $this->belongsToRelations($tableName);
        $this->hasManyRelations($tableName);
    }

    public function submit(): void {
        $stub = $this->getRelationStub($this->relationStub);
        $content = [];

        foreach (array_filter($this->relationships, fn($relationship) => $relationship['selected'] === true) as $relationship) {
            $content[] = str_replace([
                '{{ relationName }}',
                '{{ relatedModel }}',
                '{{ foreignKey }}',
                '{{ ownKey }}',
                '{{ relationType }}',
                '{{ returnType }}'
            ], [
                $relationship['relation_name'],
                $relationship['relation_model'],
                $relationship['foreign_key'],
                $relationship['own_key'],
                $relationship['relation_type'],
                $this->returnType($relationship['relation_type'])
            ], $stub);
        }

        if (count($content) > 0) {
            $location = $this->resolvePath($this->namespace);
            $array = file(base_path($location . $this->group));

            $content = implode($content);
            array_splice($array, array_key_last($array), 0, $content);

            $content = implode("", $array);
            $this->overwrite($location, $content);

            session()->flash('success', 'Relations successfully generated!');
        }

        $this->reset();
    }

    private function belongsToRelations($tableName): void {
        $foreignKeys = DB::table('information_schema.table_constraints as tc')
            ->join('information_schema.key_column_usage as kcu', function($join) {
                $join->on('tc.constraint_name', '=', 'kcu.constraint_name')
                    ->on('tc.table_name', '=', 'kcu.table_name');
            })
            ->join('information_schema.constraint_column_usage as ccu', 'ccu.constraint_name', '=', 'tc.constraint_name')
            ->where('tc.constraint_type', 'FOREIGN KEY')
            ->where('tc.table_name', $tableName)
            ->select('kcu.column_name', 'ccu.table_name as referenced_table_name', 'ccu.column_name as referenced_column_name')
            ->get();

        foreach ($foreignKeys as $foreignKey) {
            $model = $this->models->first(function($model) use ($foreignKey) {
                return app()->make($model->namespace)->getTable() === $foreignKey->referenced_table_name;
            });
            $model = '\\' . ($model->namespace ?? ('App\Models\\' . Str::studly(Str::singular($foreignKey->referenced_table_name))));
            $methodName = Str::camel($foreignKey->referenced_table_name);

            $this->relationships[] = [
                'type' => self::RELATION_TYPE_BELONGS,
                'selected' => true,
                'relation_type' => 'belongsTo',
                'relation_name' => $methodName,
                'relation_model' => $model,
                'foreign_key' => $foreignKey->column_name,
                'own_key' => $foreignKey->referenced_column_name
            ];
        }
    }

    private function hasManyRelations($tableName): void {
        $childTables = DB::table('information_schema.table_constraints as tc')
            ->join('information_schema.key_column_usage as kcu', function($join) {
                $join->on('tc.constraint_name', '=', 'kcu.constraint_name')
                    ->on('tc.table_name', '=', 'kcu.table_name');
            })
            ->join('information_schema.constraint_column_usage as ccu', 'ccu.constraint_name', '=', 'tc.constraint_name')
            ->where('tc.constraint_type', 'FOREIGN KEY')
            ->where('ccu.table_name', $tableName)  // The table you want to check for references
            ->select('tc.table_name as child_table', 'kcu.column_name as child_column', 'ccu.column_name as parent_column')
            ->get();

        foreach ($childTables as $foreignKey) {
            $model = $this->models->first(function($model) use ($foreignKey) {
                return app()->make($model->namespace)->getTable() === $foreignKey->child_table;
            });
            $model = '\\' . ($model->namespace ?? ('App\Models\\' . Str::studly(Str::singular($foreignKey->child_table))));
            $methodName = Str::camel($foreignKey->child_table);

            $this->relationships[] = [
                'type' => self::RELATION_TYPE_HAS,
                'selected' => true,
                'relation_type' => 'hasMany',
                'relation_name' => $methodName,
                'relation_model' => $model,
                'foreign_key' => $foreignKey->child_column,
                'own_key' => $foreignKey->parent_column
            ];
        }
    }

    private function returnType($relationType): string {
        return match ($relationType) {
            'belongsTo' => '\Illuminate\Database\Eloquent\Relations\BelongsTo',
            'belongsToMany' => '\Illuminate\Database\Eloquent\Relations\BelongsToMany',
            'hasMany' => '\Illuminate\Database\Eloquent\Relations\HasMany',
            'hasOne' => '\Illuminate\Database\Eloquent\Relations\HasOne'
        };
    }

    private function overwrite(string $location, string $content): void {
        $path = base_path(join("/", [$location . $this->group]));
        File::put($path, $content);
    }
}
