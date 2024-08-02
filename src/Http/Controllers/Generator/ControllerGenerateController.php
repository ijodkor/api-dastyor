<?php

namespace Ijodkor\LaravelGenerator\Http\Controllers\Generator;

use Exception;
use Ijodkor\LaravelGenerator\Services\Generator;
use Ijodkor\LaravelGenerator\Http\Controllers\Controller;
use Ijodkor\LaravelGenerator\Http\Requests\GeneratorRequest;

class ControllerGenerateController extends Controller {

    public function __construct(private readonly Generator $generator) {
    }

    public function __invoke(GeneratorRequest $request) {
        try {
            $this->generator->generateController($request->validated());
            return redirect()->back();
        } catch (Exception $exception) {
            dd($exception->getMessage());
        }
    }
}
