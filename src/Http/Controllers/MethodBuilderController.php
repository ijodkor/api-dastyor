<?php

namespace Ijodkor\Dastyor\Http\Controllers;

use Exception;
use Illuminate\Support\Arr;
use Ijodkor\Dastyor\Http\Requests\MethodBuilderRequest;
use Ijodkor\Dastyor\Services\MethodBuilderService;

class MethodBuilderController extends Controller {

    public function __construct(private readonly MethodBuilderService $method) {
    }

    public function __invoke(MethodBuilderRequest $request) {
        try {
            $attributes = $request->validated();
            $namespace = Arr::get($attributes, 'namespace');
            $name = Arr::get($attributes, 'name');
            $this->method->generate($namespace, $name);

            return redirect()->back();
        } catch (Exception $exception) {
            dd($exception->getMessage());
        }
    }
}
