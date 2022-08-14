<?php

namespace App\models;

use Drongotech\ResponseParser\Traits\ErrorParser;
use Illuminate\Database\Eloquent\Model;

class BooksModel extends Model
{
    use ErrorParser;
    protected $table = "books";

    protected $fillable = [
        "sheekh_id",
        "book_name",
        "book_written_by",
        "book_description",
        "book_num_pages",
        "book_publish_date",
        "book_is_ongoing",
        "book_icon",
        "category",
        "book_is_ongoing",
    ];

    protected $appends = [
        'book_icon_url',
    ];

    protected static $failed = "Failed to update or create book. Contact admin for support";
    public $errorMessage = null;

    public function addNewBook($data)
    {
        try {
            $data = [
                "sheekh_id" => $data["sheekha_soojediyay"],
                "book_name" => $data["magaca_buuga"],
                "book_written_by" => isset($data["qoraaga_buuga"]) ? $data["qoraaga_buuga"] : null,
                "book_description" => isset($data["faahfaahinta_buuga"]) ? $data["faahfaahinta_buuga"] : null,
                "book_num_pages" => isset($data["tirada_saxfada_buuga"]) ? $data["tirada_saxfada_buuga"] : null,
                "book_publish_date" => isset($data["taariikhda_buuga_la_qoray"]) ? $data["taariikhda_buuga_la_qoray"] : null,
                "book_is_ongoing" => isset($data["buuga_casharkiisa_socdo"]) ? $data["buuga_casharkiisa_socdo"] : false,
                "category" => isset($data["book_category"]) ? $data["book_category"] : 0,
            ];
            $book = $this->updateOrCreate(['id' => $data['book_id'] ?? 0], $data);
            return $book;
        } catch (\Throwable$th) {
            $this->errorMessage = $th->getMessage();
            $this->setError(env('APP_DEBUG') ? $th->getMessage() : $this->getError(static::$failed));
            return false;
        }
    }

    public function getBookIconUrlAttribute()
    {
        return env('APP_URL') . $this->book_icon;
    }
    public function SheekhInfo()
    {
        return $this->belongsTo(SheekhsModel::class, 'sheekh_id', 'id');
    }

    public function Casharada()
    {
        return $this->hasMany(LessonsModel::class, 'book_id', 'id')->orderBy('lesson_number');
    }

    public function Category()
    {
        return $this->belongsTo(LessonCategoriesModel::class, 'category', 'id');
    }
}
