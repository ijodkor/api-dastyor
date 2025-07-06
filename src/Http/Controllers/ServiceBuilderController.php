<?php

namespace Ijodkor\Dastyor\Http\Controllers;

use Exception;
use Illuminate\Support\Arr;
use Ijodkor\Dastyor\Http\Requests\ServiceBuilderRequest;
use Ijodkor\Dastyor\Services\ServiceBuilder;

class ServiceBuilderController extends Controller {

    public function __construct(
        private readonly ServiceBuilder $service
    ) {
    }

    /**
     * @description Service class
     */
    public function __invoke(ServiceBuilderRequest $request) {
        try {
            $data = $request->validated();
            $model = Arr::get($data, 'model');
            $name = Arr::get($data, 'name');
            $namespace = Arr::get($data, 'namespace', "");

            $this->service->generate($model, $name, $namespace);

            return redirect()->back();
        } catch (Exception $exception) {
            return redirect()->back()->with('errors');
        }
    }


    public function generateService(array $data): void {


    }
}
