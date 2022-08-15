<?php
namespace App\Services;

use App\models\LessonsModel;
use Drongotech\ResponseParser\DefaultService;

class LessonServices extends DefaultService
{
    public function getLatestLessons($request)
    {

        $this->request = $request;
        $is_json = $this->ResponseType();

        $lessons = LessonsModel::with('SheekhInfo', 'BookInfo')->limit(40)->latest()->get();

        return $is_json ? $this->Parse(false, 'success', $lessons) : $lessons;
    }

    public function getLessonById($request, $lesson_id)
    {
        $this->request = $request;
        $is_json = $this->ResponseType();

        $lesson = LessonsModel::find($lesson_id);

        return $is_json ? $this->Parse(false, 'success', $lesson) : $lesson;
    }

    public function getGivenBookLessons($request, $book_id)
    {

        $this->request = $request;
        $is_json = $this->ResponseType();

        $lessons = LessonsModel::where('book_id', $book_id)->with('SheekhInfo', 'BookInfo')->limit(40)->latest()->get();

        return $is_json ? $this->Parse(false, 'success', $lessons) : $lessons;
    }
}
