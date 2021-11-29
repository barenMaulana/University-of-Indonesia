<?php
namespace App\Services\University;

use App\Services\BaseService;
use App\Models\University;

class UpdateUniversity extends BaseService
{
    /**
     * Get validation rules that apply to the service.
     * 
     * @return array
     */
    public function rules() : array
    {
        return [
            'name' => 'required',
            'address' => 'required',
            'abbreviation' => 'required'
        ];
    }

    /**
     * Update a university.
     *
     * @param  array  $data
     * @param integer $id
     * 
     * @return University , Error
     */
    public function execute(array $data, int $id)
    {
        $validation = self::validate($data,self::rules());
        if ($validation->fails()){
            return [
                null,
                $validation->errors()->first()
            ];
        }

        $university = self::updateUniversity($data, $id);
        $university->save();

        return [
            $university,
            null
        ];
    }

    /**
     * Update a university.
     *
     * @param  array  $data
     * @param integer $id
     * 
     * @return University
     */

    private function updateUniversity(array $data, int $id) : University
    {

        $university = University::find($id);
        $university->name = $data['name'];
        $university->address = $data['address'];
        $university->abbreviation = $data['abbreviation'];

        return $university;
    }
}