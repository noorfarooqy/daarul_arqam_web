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

    public $errorMessage = null;

    public function addNewSheekh($data)
    {
        try {
            return $this->create([
                "sheekh_name" => $data["magaca_sheekha"],
                "sheekh_email" => $data["emailka_sheekha"],
                "sheekh_current_country" => $data["wadanka_sheekha"],
            ]);
        } catch (\Throwable $th) {
            $this->errorMessage = $th->getMessage();
            return false;
        }
    }

    public function Books()
    {
        return $this->hasMany(BooksModel::class, 'sheekh_id', 'id');
    }

    public function BookCount()
    {
        return $this->Books->count();
    }

    public function Casharada()
    {
        return $this->hasMany(LessonsModel::class, 'sheekh_id', 'id');
    }
}
