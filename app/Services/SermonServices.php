<?php
namespace App\Services;

use App\models\SermonsModel;
use Drongotech\ResponseParser\DefaultService;

class SermonServices extends DefaultService
{
    public function getLatestSermons($request)
    {
        $this->request = $request;
        $is_json = $this->ResponseType();

        $sermons = SermonsModel::whereHas('SheekhInfo')->latest()->get();

        return $is_json ? $this->Parse(false, 'success', $sermons) : $sermons;
    }
}
