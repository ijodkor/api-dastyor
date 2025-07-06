<?php

namespace Ijodkor\Dastyor\Http\Controllers\Advanced;

use Exception;
use Illuminate\Contracts\View\View;
use Ijodkor\Dastyor\Http\Controllers\Controller;
use Ijodkor\Dastyor\Http\Requests\CrudBuilderRequest;
use Ijodkor\Dastyor\Services\GeneratorService;

class CrudController extends Controller {

    public function __construct(private readonly GeneratorService $service) {
    }

    public function create(): View {
        return view('generator::crud.create');
    }

    public function store(CrudBuilderRequest $request) {
        try {
            $this->service->crud($request->validated());
            return redirect()->back();
        } catch (Exception $ex) {
            return redirect()->back()->with('msg', $ex->getMessage());
        }
    }
}
