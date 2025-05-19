<?php

namespace Ijodkor\Dastyor\Http\Controllers;

use Exception;
use Illuminate\Support\Arr;
use Ijodkor\Dastyor\Http\Requests\GeneratorRequest;
use Ijodkor\Dastyor\Services\ControllerBuilderService;

class ControllerBuilderController extends Controller {

    public function __construct(private readonly ControllerBuilderService $service) {
    }

    public function __invoke(GeneratorRequest $request) {
        try {
            $attributes = $request->validated();
            $model = Arr::get($attributes, 'model');
            $name = Arr::get($attributes, 'name');
            $namespace = Arr::get($attributes, 'namespace');

            $this->service->generate($model, $name, $namespace);

            return redirect()->back();
        } catch (Exception $exception) {
            dd($exception->getMessage());
        }
    }
}
