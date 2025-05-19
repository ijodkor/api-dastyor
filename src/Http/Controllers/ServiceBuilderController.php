<?php

namespace Uzinfocom\Dastyor\Http\Controllers;

use Exception;
use Illuminate\Support\Arr;
use Uzinfocom\Dastyor\Http\Requests\GenerateServiceRequest;
use Uzinfocom\Dastyor\Services\ServiceBuilder;

class ServiceBuilderController extends Controller {

    public function __construct(
        private readonly ServiceBuilder $service
    ) {
    }

    /**
     * @description Service class
     */
    public function __invoke(GenerateServiceRequest $request) {
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
