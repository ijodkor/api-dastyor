<?php

namespace Ijodkor\Dastyor\Http\Controllers\Builders;

use Exception;
use Illuminate\Support\Arr;
use Ijodkor\Dastyor\Http\Controllers\Controller;
use Ijodkor\Dastyor\Http\Requests\GeneratorRequest;
use Ijodkor\Dastyor\Services\RequestBuilderService;

class RequestBuilderController extends Controller {

    public function __construct(private readonly RequestBuilderService $service) {
    }

    public function __invoke(GeneratorRequest $request) {
        try {
            $data = $request->validated();
            $model = Arr::get($data, 'model');
            $hasFilter = Arr::get($data, 'list_request');

            /** Request class **/
            $name = Arr::get($data, 'name');
            $namespace = Arr::get($data, 'namespace');

            /** Request create **/
            $this->service->creating($model, $name, $namespace);
            /** Request update **/
            $this->service->updating($model, $name, $namespace);

            /** Request list **/
            if ($hasFilter) {
                $this->service->generateList($model, $name, $namespace);
            }
            return redirect()->back();
        } catch (Exception $exception) {
            dd($exception->getMessage());
        }
    }
}
