<?php

namespace Uzinfocom\Dastyor\Http\Controllers\Builders;

use Exception;
use Illuminate\Support\Arr;
use Uzinfocom\Dastyor\Http\Controllers\Controller;
use Uzinfocom\Dastyor\Http\Requests\ModelGenerateRequest;
use Uzinfocom\Dastyor\Services\ModelBuilderService;

class ModelBuilderController extends Controller {

    public function __construct(private readonly ModelBuilderService $service) { }

    public function __invoke(ModelGenerateRequest $request) {
        try {
            $data = $request->validated();
            $table = Arr::get($data, 'table');

            /** Model class **/
            $name = Arr::get($data, 'name');
            $namespace = Arr::get($data, 'namespace');
            $this->service->generate($table, $name, $namespace);
            return redirect()->back();
        } catch (Exception $exception) {
            dd($exception->getMessage());
        }
    }
}
