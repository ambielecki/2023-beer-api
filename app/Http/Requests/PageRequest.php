<?php

namespace App\Http\Requests;

use App\Page;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PageRequest extends FormRequest
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
            'app' => 'string|required|' . Rule::in(Page::APPS),
            'page' => 'string|required|' . Rule::in(Page::PAGE_TYPES),
            'content' => 'string|required',
        ];
    }
}
