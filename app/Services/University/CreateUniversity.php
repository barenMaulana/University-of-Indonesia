<?php

namespace App\Services\University;

use App\Services\BaseService;
use App\Models\University;

class CreateUniversity extends BaseService
{
    /**
     * Get the validation rules that apply to the service.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|unique:universities,name',
            'address' => 'required',
            'abbreviation' => 'required'
        ];
    }


    /**
     * Create a university.
     *
     * @param  array  $data
     * @return University , Error
     */
    public function execute(array $data)
    {
        $validation = $this->validate($data);
        if ($validation->fails()) {
            return [
                null,
                $validation->errors()->first()
            ];
        }

        $university = self::createUniversity($data);
        $university->save();

        return [$university,null];
    }

    /**
     * Create a university.
     *
     * @param  array  $data
     * @return University
     */
    protected function createUniversity($data) : University
    {
        $university = new University();
        $university->name = $data['name'];
        $university->address = $data['address'];
        $university->abbreviation = $data['abbreviation'];

        return $university;
    }
}