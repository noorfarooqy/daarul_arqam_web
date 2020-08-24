<?php

namespace App\Http\Controllers;

use App\models\BooksModel;
use App\models\LessonsModel;
use App\models\SermonsModel;
use App\models\SheekhsModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response as FacadesResponse;
use Illuminate\Support\Facades\Validator;

class MainController extends Controller
{
    //

    public function OpenIndexPage()
    {
        return view('home');
    }

    public function AddSheekhForm(Request $request)
    {

        return view('sheekhs.add_form');
    }

    public function ListSheekhs(Request $request)
    {
        $sheekhs = SheekhsModel::get();
        return view('sheekhs.list_sheekhs', compact('sheekhs'));
    }

    public function ListBooks(Request $request)
    {
        $books = BooksModel::get();
        return view('books.list_books', compact('books'));
    }
    public function ListLesson(Request $request)
    {
        $lessons = LessonsModel::get();
        return view('lessons.list_lessons', compact('lessons'));
    }

    public function ListSermons(Request $request)
    {
        $muxaadarooyinka = SermonsModel::get();
        return view('sermons.list_sermons', compact('muxaadarooyinka'));
    }

    public function AddBookForm(Request $request)
    {
        $sheekhs = SheekhsModel::get();
        return view('books.add_form', compact('sheekhs'));
    }
    public function AddLessonForm(Request $request, $book_id)
    {
        $book = BooksModel::where('id', $book_id)->get();
        if ($book == null || $book->count() <= 0)
            abort(404);
        $book = $book[0];
        return view('lessons.add_form', compact('book'));
    }

    public function AddSermonForm(Request $request)
    {
        $sheekhs = SheekhsModel::get();
        return view('sermons.add_form', compact('sheekhs'));
    }

    public function AddBookToDB(Request $request)
    {
        $rules = [
            "sheekha_soojediyay" => "required|integer|exists:sheekhs,id",
            "magaca_buuga" => "required|string|max:255",
            "qoraaga_buuga" => "nullable|string|max:255",
            "faahfaahinta_buuga" => "nullable|string|max:255|min:3",
            "tirada_saxfada_buuga" => "nullable|numeric|max:999|min:1",
            "taariikhda_buuga_la_qoray" => "nullable|date|before:now",
            "buuga_casharkiisa_socdo" => "nullable|in:on,off"
        ];

        $data =  $request->validate($rules);

        $BookModel = new BooksModel();

        $success = $BookModel->addNewBook($data);

        if ($success)
            return Redirect::back()->with('success', 'successfully added new book');

        return Redirect::back()->withErrors(['errorMessage' => $BookModel->errorMessage]);
    }

    public function AddSheekhToDB(Request $request)
    {
        $rules = [
            "magaca_sheekha" => "required|string|max:255",
            "emailka_sheekha" => "required|email|max:75",
            "wadanka_sheekha" => "required|string|max:75"
        ];

        $data = $request->validate($rules);


        $SheekhModel = new SheekhsModel();

        $success = $SheekhModel->addNewSheekh($data);
        if ($success)
            return Redirect::back()->with('success', 'successfully added new sheekh');

        return Redirect::back()->withErrors(['errorMessage' => $SheekhModel->errorMessage]);
    }

    public function AddLessonToDB(Request $request, $book_id)
    {

        $book = BooksModel::where('id', $book_id)->get();
        if ($book == null || $book->count() <= 0)
            abort(404);
        $book = $book[0];
        $rules = [
            "cinwaanka_casharka" => "required|string|max:255",
            "numbarka_casharka" => "nullable|integer",
            "fileka_casharka" => "required|file|mimes:audio/mpeg,mp3,wav",
        ];

        if ($request->expectsJson()) {
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return FacadesResponse::json([
                    "errorMessage" => $validator->errors()->first(),
                    "isSuccess" => false,
                    "data" => []
                ]);
            }
            $data = $validator->validated();
        } else
            $data = $request->validate($rules);

        if ($request->hasFile('fileka_casharka')) {
            $uniqueid = uniqid();
            $cashar_folder = hash('md5', $book->id);

            try {
                $original_name = $request->file('fileka_casharka')->getClientOriginalName();
                $size = $request->file('fileka_casharka')->getSize();
                $extension = $request->file('fileka_casharka')->getClientOriginalExtension();
                $name = $original_name . '_' . $uniqueid . '.' . $extension;
                $fileurl = url('/storage/uploads/lessons/' . $cashar_folder . '/' . $name);
                $path = $request->file('fileka_casharka')->storeAs('public/uploads/lessons/' . $cashar_folder . '/', $name);
                $LessonModel = new LessonsModel();

                $data["file_casharka"] = $fileurl;
                $data["file_size"] = $size;
                $success = $LessonModel->addNewLesson($data, $book);
                if ($success) {
                    if ($request->expectsJson()) {
                        return FacadesResponse::json([
                            "errorMessage" => 'successfully added new sheekh',
                            "isSuccess" => true,
                            "data" => []
                        ]);
                    } else
                        return Redirect::back()->with('success', 'successfully added new sheekh');
                } else {

                    if ($request->expectsJson()) {
                        return FacadesResponse::json([
                            "errorMessage" => $LessonModel->errorMessage,
                            "isSuccess" => false,
                            "data" => []
                        ]);
                    } else
                        return Redirect::back()->withErrors(['errorMessage' => $LessonModel->errorMessage]);
                }
            } catch (\Throwable $th) {
                if ($request->expectsJson()) {
                    return FacadesResponse::json([
                        "errorMessage" => $th->getMessage(),
                        "isSuccess" => false,
                        "data" => []
                    ]);
                } else
                    return Redirect::back()->withErrors(['errorMessage' => $th->getMessage()]);
            }
        } else {
            if ($request->expectsJson()) {
                return FacadesResponse::json([
                    "errorMessage" => 'The lesson audio file is not given',
                    "isSuccess" => false,
                    "data" => []
                ]);
            } else
                Redirect::back()->withErrors(['errorMessage' => 'The lesson audio file is not given']);
        }
    }

    public function AddSermonToDB(Request $request)
    {


        $rules = [
            "cinwaanka_muxaadara" => "required|string|max:255",
            "sheekha" => "required|integer|exists:sheekhs,id",
            "goobta_muxaadarada" => "required|string|max:255,min:3",
            "fileka_muxaadarada" => "required|file|mimes:audio/mpeg,mp3,wav",
        ];

        if ($request->expectsJson()) {
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return FacadesResponse::json([
                    "errorMessage" => $validator->errors()->first(),
                    "isSuccess" => false,
                    "data" => []
                ]);
            }
            $data = $validator->validated();
        } else
            $data = $request->validate($rules);

        if ($request->hasFile('fileka_muxaadarada')) {
            $uniqueid = uniqid();
            $muxaadaro_folder = hash('md5', $request->sheekha);

            try {
                $original_name = $request->file('fileka_muxaadarada')->getClientOriginalName();
                $size = $request->file('fileka_muxaadarada')->getSize();
                $extension = $request->file('fileka_muxaadarada')->getClientOriginalExtension();
                $name = $original_name . '_' . $uniqueid . '.' . $extension;
                $fileurl = url('/storage/uploads/muxaadaro/' . $muxaadaro_folder . '/' . $name);
                $path = $request->file('fileka_muxaadarada')->storeAs('public/uploads/muxaadaro/' . $muxaadaro_folder . '/', $name);
                $SermonModel = new SermonsModel();

                $data["fileka_muxaadarada"] = $fileurl;
                $data["file_size"] = $size;
                $success = $SermonModel->addNewMuxaadaro($data);
                if ($success) {
                    if ($request->expectsJson()) {
                        return FacadesResponse::json([
                            "errorMessage" => 'successfully added new muxadaaro',
                            "isSuccess" => true,
                            "data" => []
                        ]);
                    } else
                        return Redirect::back()->with('success', 'successfully added new sheekh');
                } else {

                    if ($request->expectsJson()) {
                        return FacadesResponse::json([
                            "errorMessage" => $SermonModel->errorMessage,
                            "isSuccess" => false,
                            "data" => []
                        ]);
                    } else
                        return Redirect::back()->withErrors(['errorMessage' => $SermonModel->errorMessage]);
                }
            } catch (\Throwable $th) {
                if ($request->expectsJson()) {
                    return FacadesResponse::json([
                        "errorMessage" => $th->getMessage(),
                        "isSuccess" => false,
                        "data" => []
                    ]);
                } else
                    return Redirect::back()->withErrors(['errorMessage' => $th->getMessage()]);
            }
        } else {
            if ($request->expectsJson()) {
                return FacadesResponse::json([
                    "errorMessage" => 'The lesson audio file is not given',
                    "isSuccess" => false,
                    "data" => []
                ]);
            } else
                Redirect::back()->withErrors(['errorMessage' => 'The muxaadaro audio file is not given']);
        }
    }


    public function openAPIGetSheekhList()
    {
        $sheekhs = SheekhsModel::latest()->get();
        foreach ($sheekhs as $key => $sheekh) {
            $sheekhs[$key]["book_count"] = $sheekh->BookCount();
            $sheekhs[$key]["lesson_count"] = $sheekh->Casharada->count();
            unset($sheekhs[$key]->Books);
            unset($sheekhs[$key]->Casharada);
        }
        return FacadesResponse::json([
            "errorMessage" => null,
            "isSuccess" => true,
            "data" => $sheekhs
        ]);
    }

    public function openAPIGetBooksList()
    {
        $books = BooksModel::latest()->get();

        foreach ($books as $key => $book) {
            $book->SheekhInfo;
            $books[$key]["lesson_count"] = $book->Casharada->count();
            unset($books[$key]->Casharada);
        }
        return FacadesResponse::json([
            "errorMessage" => null,
            "isSuccess" => true,
            "data" => $books
        ]);
    }
    public function openAPIGetLessonsList()
    {
        $lessons = LessonsModel::with('SheekhInfo', 'BookInfo')->latest()->get();

        return FacadesResponse::json([
            "errorMessage" => null,
            "isSuccess" => true,
            "data" => $lessons
        ]);
    }

    public function openAPISermonsList()
    {
        $sermons = SermonsModel::with('SheekhInfo')->latest()->get();

        return FacadesResponse::json([
            "errorMessage" => null,
            "isSuccess" => true,
            "data" => $sermons
        ]);
    }
    public function openAPIGetGivenSheekh($sheekh_id)
    {

        $sheekh = SheekhsModel::where('id', $sheekh_id)->get();
        if ($sheekh != null && $sheekh->count() > 0) {
            $books = $sheekh[0]->Books;
            foreach ($books as $key => $book) {
                $books[$key]["lesson_count"] = $book->Casharada->count();
                unset($books[$key]->Casharada);
            }
            $sheekh = $sheekh[0];
        }


        return FacadesResponse::json([
            "errorMessage" => null,
            "isSuccess" => true,
            "data" => $sheekh
        ]);
    }
    public function openAPIGetGivenBook($book_id)
    {

        $book = BooksModel::where('id', $book_id)->get();
        if ($book != null && $book->count() > 0) {
            $lessons = $book[0]->Casharada;
            foreach ($lessons as $key => $lesson) {
                $lesson->sheekhInfo;
            }
            $book = $book[0];
        }


        return FacadesResponse::json([
            "errorMessage" => null,
            "isSuccess" => true,
            "data" => $book
        ]);
    }
}
