<?php

namespace Uzinfocom\LaravelGenerator\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MigrationMakeRequest extends FormRequest {
    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        return [
            'name' => 'required|string|between:2,255',
            'columns.*.name' => 'required|string',
            'columns.*.type' => 'required|string',
            'columns.*.default' => 'string|nullable',
            'columns.*.index' => 'boolean|nullable',
            'columns.*.relation' => 'string|nullable',
            'namespace' => 'string|nullable'
        ];
    }
}
