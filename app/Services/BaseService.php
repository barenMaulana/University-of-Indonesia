<?php

namespace App\Services;
use Illuminate\Support\Facades\Validator;

abstract class BaseService{
    /**
     * Get the validation rules that apply to the service.
     *
     * @return array
     */
    public function rules()
    {
        return [];
    }


    /**
     * Validate all datas to execute the service.
     *
     * @param  array  $data
     * @return mixed
     */
    public function validate(array $data)
    {
        $validation = Validator::make($data, $this->rules());
        return $validation;
    }    

}