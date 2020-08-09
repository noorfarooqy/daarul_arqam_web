<?php

namespace App\Http\Controllers;

use App\models\BooksModel;
use App\models\LessonsModel;
use App\models\SheekhsModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response as FacadesResponse;

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
                if ($success)
                    return Redirect::back()->with('success', 'successfully added new sheekh');

                return Redirect::back()->withErrors(['errorMessage' => $LessonModel->errorMessage]);
            } catch (\Throwable $th) {
                return Redirect::back()->withErrors(['errorMessage' => $th->getMessage()]);
            }
        } else
            Redirect::back()->withErrors(['errorMessage' => 'The lesson audio file is not given']);
    }

    public function openAPIGetSheekhList()
    {

        $sheekhs = SheekhsModel::get();
        foreach ($sheekhs as $key => $sheekh) {
            $sheekhs[$key]["book_count"] = $sheekh->BookCount();
            unset($sheekhs[$key]->Books);
        }
        return FacadesResponse::json([
            "errorMessage" => null,
            "isSuccess" => true,
            "data" => $sheekhs
        ]);
    }

    public function openAPIGetBooksList()
    {
        $books = BooksModel::get();

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
        $lessons = LessonsModel::with('SheekhInfo', 'BookInfo')->get();

        return FacadesResponse::json([
            "errorMessage" => null,
            "isSuccess" => true,
            "data" => $lessons
        ]);
    }

    public function openAPIGetGivenSheekh($sheekh_id)
    {

        $sheekh = SheekhsModel::where('id', $sheekh_id)->get();
        if ($sheekh != null && $sheekh->count() > 0)
            $sheekh[0]->Books;
        return FacadesResponse::json([
            "errorMessage" => null,
            "isSuccess" => true,
            "data" => $sheekh
        ]);
    }
    public function openAPIGetGivenBook($book_id)
    {

        $book = BooksModel::where('id', $book_id)->get();
        if ($book != null && $book->count() > 0)
            $book[0]->Casharada;
        return FacadesResponse::json([
            "errorMessage" => null,
            "isSuccess" => true,
            "data" => $book
        ]);
    }
}
