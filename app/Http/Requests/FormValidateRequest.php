<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class FormValidateRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    protected $rules = [];
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
        return $this->rules;
    }

    public function setRules( $rulesArr )
    {
        $this->rules = $rulesArr;
        var_dump($this->rules);
    }
}
