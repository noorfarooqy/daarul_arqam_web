<?php
namespace App\Services;

use App\models\SheekhsModel;
use Drongotech\ResponseParser\DefaultService;

class SheekhServices extends DefaultService
{
    public function getLatestsheikhsList($request)
    {
        $this->request = $request;
        $is_json = $this->ResponseType();

        $sheekhs = SheekhsModel::latest()->limit($request->limit ?? 20)->get();

        return $is_json ? $this->Parse(false, 'success', $sheekhs) : $sheekhs;
    }

}
