<?php
namespace App\Services;

use App\models\LessonCategoriesModel;
use Drongotech\ResponseParser\DefaultService;

class CategoriesServices extends DefaultService
{

    public function getCategoriesList($request)
    {
        $this->request = $request;
        $is_json = $this->ResponseType();

        $categories = LessonCategoriesModel::where('is_active', true)->get();

        return $is_json ? $this->Parse(false, 'success', $categories) : $categories;
    }
}
