<?php

namespace Ijodkor\Dastyor\Http\Requests;

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
            'namespace' => 'string|nullable'
        ];
    }
}
