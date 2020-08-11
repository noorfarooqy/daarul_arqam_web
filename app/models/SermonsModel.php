<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class SermonsModel extends Model
{
    //
    protected $table = "sermons";

    protected $fillable = [
        "sheekh_id",
        "sermon_title",
        "sermon_location",
        "sermon_file_url",
        "sermon_file_size",
    ];

    public $errorMessage = null;

    public function addNewMuxaadaro($data)
    {

        try {
            return $this->create([
                "sheekh_id" => $data["sheekha"],
                "sermon_title" => $data["cinwaanka_muxaadara"],
                "sermon_location" => $data["goobta_muxaadarada"],
                "sermon_file_url" => $data["fileka_muxaadarada"],
                "sermon_file_size" => $data["file_size"],

            ]);
        } catch (\Throwable $th) {
            //throw $th;
            $this->errorMessage = $th->getMessage();
        }
    }

    public function SheekhInfo()
    {
        return $this->belongsTo(SheekhsModel::class, 'sheekh_id', 'id');
    }
}
