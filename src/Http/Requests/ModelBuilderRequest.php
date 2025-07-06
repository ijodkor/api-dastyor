<?php

namespace Ijodkor\Dastyor\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ModelBuilderRequest extends FormRequest {
    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        return [
            'table.name' => 'required|string|between:2,255',
            'name' => 'required|string|between:2,255',
            'namespace' => 'string|nullable'
        ];
    }
}
