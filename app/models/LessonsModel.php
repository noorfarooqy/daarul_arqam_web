<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class LessonsModel extends Model
{
    //
    protected $table = "lessons";

    protected $fillable = [
        "book_id",
        "sheekh_id",
        "lesson_title",
        "lesson_hidden",
        "lesson_number",
        "lesson_audio_url",
        "file_size",
    ];

    public $errorMessage = null;

    public function addNewLesson($data, $book)
    {
        try {
            return $this->create([
                "book_id" => $book->id,
                "sheekh_id" => $book->sheekh_id,
                "lesson_title" => $data["cinwaanka_casharka"],
                "lesson_number" => isset($data["numbarka_casharka"]) ? $data["numbarka_casharka"] : ($book->Lessons->count() + 1),
                "lesson_audio_url" => $data["file_casharka"],
                "file_size" => $data["file_size"],
            ]);
        } catch (\Throwable$th) {
            $this->errorMessage = $th->getMessage();
            return false;
        }
    }
    public function updateLesson($data, $book, $lesson)
    {
        try {
            return $lesson->update([
                "lesson_title" => $data["cinwaanka_casharka"],
                "lesson_number" => isset($data["numbarka_casharka"]) ? $data["numbarka_casharka"] : ($lesson->lesson_number),
                "lesson_audio_url" => isset($data["file_casharka"]) ? $data["file_casharka"] : $lesson->lesson_audio_url,
                "file_size" => isset($data["file_size"]) ? $data["file_size"] : $lesson->file_size,
            ]);
        } catch (\Throwable$th) {
            $this->errorMessage = $th->getMessage();
            return false;
        }
    }

    public function SheekhInfo()
    {
        return $this->belongsTo(SheekhsModel::class, 'sheekh_id', 'id');
    }
    public function BookInfo()
    {
        return $this->belongsTo(BooksModel::class, 'book_id', 'id');
    }
}
