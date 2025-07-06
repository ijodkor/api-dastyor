<?php

namespace Ijodkor\Dastyor\Http\Controllers\Builders;

use Exception;
use Illuminate\Support\Arr;
use Ijodkor\Dastyor\Http\Controllers\Controller;
use Ijodkor\Dastyor\Http\Requests\EnumGenerateRequest;
use Ijodkor\Dastyor\Services\GenerateEnum;

class EnumBuilderController extends Controller {

    public function __construct(private readonly GenerateEnum $enum) {
    }

    public function __invoke(EnumGenerateRequest $request) {
        try {
            $attributes = $request->validated();

            $name = Arr::get($attributes, 'name');
            $type = Arr::get($attributes, 'type');
            $namespace = Arr::get($attributes, 'namespace');
            $variables = Arr::get($attributes, 'variables');

            $this->enum->generate($namespace, $name, $type, $variables);

            return redirect()->back();
        } catch (Exception $exception) {
            dd($exception->getMessage());
        }
    }
}
