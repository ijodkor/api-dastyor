<?php

namespace Uzinfocom\Dastyor\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CrudRequest extends FormRequest {

    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        return [
            'model' => 'required|string|between:2,255',
            // controller
            'controller.base' => 'required|string|between:2,255',
            'controller.prefix' => 'required|string|between:2,255',
            'controller.name' => 'required|string|between:2,255',
            'controller.suffix' => 'required|string|between:2,255',
            // create request
            'request.create_prefix' => 'required|string|between:2,255',
            'request.create_name' => 'required|string|between:2,255',
            'request.create_suffix' => 'required|string|between:2,255',
            // update request
            'request.update_prefix' => 'required|string|between:2,255',
            'request.update_name' => 'required|string|between:2,255',
            'request.update_suffix' => 'required|string|between:2,255',
            'request.list_request' => 'boolean',

            // crud
            'crud.type' => 'required|integer',
        ];
    }
}
