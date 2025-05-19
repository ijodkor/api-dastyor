<?php

namespace Ijodkor\Dastyor\Http\Controllers\Builders;

use Exception;
use Illuminate\Support\Arr;
use Ijodkor\Dastyor\Http\Controllers\Controller;
use Ijodkor\Dastyor\Http\Requests\GeneratorRequest;
use Ijodkor\Dastyor\Services\ResourceBuilderService;

class ResourceBuilderController extends Controller {

    public function __construct(private readonly ResourceBuilderService $service) {
    }

    public function __invoke(GeneratorRequest $request) {
        try {
            $attributes = $request->validated();
            $model = Arr::get($attributes, 'model');

            /** Resource class **/
            $name = Arr::get($attributes, 'name');
            $namespace = Arr::get($attributes, 'namespace');

            $this->service->generate($model, $name, $namespace);
            return redirect()->back();
        } catch (Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }
}
