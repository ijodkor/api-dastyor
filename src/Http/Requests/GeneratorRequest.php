<?php

namespace Ijodkor\Dastyor\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GeneratorRequest extends FormRequest {

    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        return [
                'model.name' => 'required|string|between:2,255',
                'model.namespace' => 'required|string|between:2,255',
                'name' => 'required|string|between:2,255',
                'namespace' => '',
                'list_request' => 'boolean',
        ];
    }
}
