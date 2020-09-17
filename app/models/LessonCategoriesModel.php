<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class LessonCategoriesModel extends Model
{
    //
    protected $table = "lesson_categories";
    protected $fillable = [
        "category_name",
        "parent_category",
        "is_active"
    ];
    public $errorMessage = null;

    public function addCategory($data)
    {
        try {
            return $this->create([
                "category_name" => $data["category_name"],
                "parent_category" => $data["parent_category"],
            ]);
        } catch (\Throwable $th) {
            $this->errorMessage = $th->getMessage();
        }
    }

    public function Parent()
    {
        return $this->belongsTo(LessonCategoriesModel::class, 'parent_category');
    }

    public function Books()
    {
        return $this->hasMany(BooksModel::class, 'category', 'id');
    }
}
