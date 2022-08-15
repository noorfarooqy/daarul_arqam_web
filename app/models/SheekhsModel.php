<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class SheekhsModel extends Model
{
    //
    protected $table = "sheekhs";

    protected $fillable = [
        "sheekh_name",
        "sheekh_email",
        "sheekh_current_country",
        "sheekh_icon",
    ];

    protected $appends = [
        // 'book_count', 'lesson_count',
    ];

    public $errorMessage = null;

    public function addNewSheekh($data)
    {
        try {
            return $this->create([
                "sheekh_name" => $data["magaca_sheekha"],
                "sheekh_email" => $data["emailka_sheekha"],
                "sheekh_current_country" => $data["wadanka_sheekha"],
            ]);
        } catch (\Throwable$th) {
            $this->errorMessage = $th->getMessage();
            return false;
        }
    }

    public function Books()
    {
        return $this->hasMany(BooksModel::class, 'sheekh_id', 'id');
    }

    public function getBookCountAttribute()
    {
        return $this->BookCount();
    }
    public function getLessonCountAttribute()
    {
        return $this->LessonCount();
    }
    public function BookCount()
    {
        return $this->Books->count();
    }
    public function LessonCount()
    {
        return $this->Lessons->count();
    }

    public function Lessons()
    {
        return $this->hasMany(LessonsModel::class, 'sheekh_id', 'id');
    }
}
