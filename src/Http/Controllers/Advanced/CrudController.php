<?php

namespace Uzinfocom\Dastyor\Http\Controllers\Advanced;

use Exception;
use Illuminate\Contracts\View\View;
use Uzinfocom\Dastyor\Http\Controllers\Controller;
use Uzinfocom\Dastyor\Http\Requests\CrudRequest;
use Uzinfocom\Dastyor\Services\GeneratorService;

class CrudController extends Controller {

    public function __construct(private readonly GeneratorService $service) {
    }

    public function create(): View {
        return view('generator::advanced.crud.create');
    }

    public function store(CrudRequest $request) {
        try {
            $this->service->crud($request->validated());
            return redirect()->back();
        } catch (Exception $ex) {
            return redirect()->back()->with('msg', $ex->getMessage());
        }
    }
}
