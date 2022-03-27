<?php

namespace App\Http\Requests\NearBySearch;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Http\Models\Setting;

class GetRequest extends FormRequest
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
            'lat' => 'required|numeric|between:' . Setting::LAT['min'] . ',' . Setting::LAT['max'],
            'lng' => 'required|numeric|between:' . Setting::LNG['min'] . ',' . Setting::LNG['max'],
            'keyword' => 'required|string',
            'direction_type' => 'required|integer|between:' . Setting::DIRECTION_TYPE['none'] . ',' . Setting::DIRECTION_TYPE['west'],
            'min' => 'required|numeric|between:0, 100',
            'max' => 'required|numeric|between:0, 100',
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
