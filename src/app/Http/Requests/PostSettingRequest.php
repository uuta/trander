<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Http\Models\Setting;

class PostSettingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'min_distance' => 'required|integer|between:0, 100',
            'max_distance' => 'required|integer|between:0, 100',
            'direction_type' => 'required|integer|between:' . Setting::DIRECTION_TYPE['none'] . ',' . Setting::DIRECTION_TYPE['west'],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $res = response()->json([
            'errors' => $validator->errors(),
        ], 422);
        throw new HttpResponseException($res);
    }
}
