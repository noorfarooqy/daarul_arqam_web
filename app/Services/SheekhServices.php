<?php
namespace App\Services;

use App\models\BooksModel;
use App\models\LessonCategoriesModel;
use App\models\SheekhsModel;
use Drongotech\ResponseParser\DefaultService;

class SheekhServices extends DefaultService
{
    public function getLatestsheikhsList($request)
    {
        $this->request = $request;
        $is_json = $this->ResponseType();

        $sheekhs = SheekhsModel::withCount('Lessons', 'Books')->latest()->limit($request->limit ?? 20)->get();

        return $is_json ? $this->Parse(false, 'success', $sheekhs) : $sheekhs;
    }

    public function getGivenSheekhDetails($request, $sheekh_id)
    {
        $this->request = $request;
        $is_json = $this->ResponseType();

        $sheekhs = SheekhsModel::where('id', $sheekh_id)->with('Books')->get()->first();
        if (!$sheekhs) {
            $this->setError($m = "Sheekh id provided is not found");
            return $is_json ? $this->_404Response($m) : false;
        }

        return $is_json ? $this->Parse(false, 'success', $sheekhs) : $sheekhs;
    }

    public function getSheekhCategories($request, $sheekh_id)
    {
        // return 'ready';

        $this->request = $request;
        $is_json = $this->ResponseType();

        $sheekhs = SheekhsModel::find($sheekh_id);
        if (!$sheekhs) {
            $this->setError($m = "Sheekh id provided is not found");
            return $is_json ? $this->_404Response($m) : false;
        }

        $categories = LessonCategoriesModel::with('Books')->whereHas('Books', function ($q) use ($sheekhs) {
            $q->where('sheekh_id', $sheekhs->id);
        })->get();
        // return $categories ?? 'empty';

        return $is_json ? $this->Parse(false, 'success', $categories) : $categories;
    }

    public function getGivenSheekhCategoryBooks($request, $sheekh_id, $category)
    {
        // return 'ready';

        $this->request = $request;
        $is_json = $this->ResponseType();

        $sheekhs = SheekhsModel::find($sheekh_id);
        if (!$sheekhs) {
            $this->setError($m = "Sheekh id provided is not found");
            return $is_json ? $this->_404Response($m) : false;
        }
        $category = LessonCategoriesModel::find($category);
        if (!$category) {
            $this->setError($m = "category id provided is not found");
            return $is_json ? $this->_404Response($m) : false;
        }

        $books = BooksModel::whereHas('Category', function ($q) use ($category) {
            $q->where('category', $category->id);
        })->limit(50)->get();

        return $is_json ? $this->Parse(false, 'success', $books) : $books;
    }

}
