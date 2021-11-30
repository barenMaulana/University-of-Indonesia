<?php
namespace App\Services\University;

use App\Models\University;
use App\Services\BaseService;

class DeleteUniversity extends BaseService
{
    /**
     * Delete university
     * 
     * @param integer $id
     * 
     * @return App\Models\University, string error
     */
    public function execute($id)
    {
        if(self::checkValue($id,University::class) != true){
            return [
                null,
                'Wrong id university'
            ];
        }

        $university = self::deleteUniversity($id);
        return [
            $university,
            null
        ];
    }

    /**
     * Delete university
     * 
     * @param integer $id
     * 
     * @return collection
     */
    private function deleteUniversity($id)
    {
        $university = University::find($id);
        $university = $university->delete();
        return $university;
    }
}