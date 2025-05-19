<?php

namespace Uzinfocom\Dastyor\Http\Controllers\Builders;

use Exception;
use Illuminate\Support\Arr;
use Uzinfocom\Dastyor\Http\Controllers\Controller;
use Uzinfocom\Dastyor\Http\Requests\GenerateEnumRequest;
use Uzinfocom\Dastyor\Services\GenerateEnum;

class EnumBuilderController extends Controller {

    public function __construct(private readonly GenerateEnum $enum) {
    }

    public function __invoke(GenerateEnumRequest $request) {
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
