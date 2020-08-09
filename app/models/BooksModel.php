<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class BooksModel extends Model
{
    //
    //
    protected $table = "books";

    protected $fillable = [
        "sheekh_id",
        "book_name",
        "book_written_by",
        "book_description",
        "book_num_pages",
        "book_publish_date",
        "book_is_ongoing",
        "book_icon"
    ];

    public $errorMessage = null;

    public function addNewBook($data)
    {
        try {
            return $this->create([
                "sheekh_id" => $data["sheekha_soojediyay"],
                "book_name"  => $data["magaca_buuga"],
                "book_written_by"  => isset($data["qoraaga_buuga"]) ? $data["qoraaga_buuga"] : null,
                "book_description"  => isset($data["faahfaahinta_buuga"]) ? $data["faahfaahinta_buuga"] : null,
                "book_num_pages"  => isset($data["tirada_saxfada_buuga"]) ? $data["tirada_saxfada_buuga"] : null,
                "book_publish_date"  => isset($data["taariikhda_buuga_la_qoray"]) ? $data["taariikhda_buuga_la_qoray"] : null,
                "book_is_ongoing"  => isset($data["buuga_casharkiisa_socdo"]) ? $data["buuga_casharkiisa_socdo"] : false,
            ]);
        } catch (\Throwable $th) {
            $this->errorMessage = $th->getMessage();
            return false;
        }
    }

    public function SheekhInfo()
    {
        return $this->belongsTo(SheekhsModel::class, 'sheekh_id', 'id');
    }

    public function Casharada()
    {
        return $this->hasMany(LessonsModel::class, 'book_id', 'id');
    }
}
