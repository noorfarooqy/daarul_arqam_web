<?php

namespace App\Http\Controllers;

use App\models\BooksModel;
use App\models\LessonCategoriesModel;
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
        $sheekhs = SheekhsModel::latest()->get();
        return view('sheekhs.list_sheekhs', compact('sheekhs'));
    }

    public function ListBooks(Request $request)
    {
        $books = BooksModel::latest()->get();
        return view('books.list_books', compact('books'));
    }

    public function openBooksFromCategory(Request $request, $cat_id)
    {
        $books = BooksModel::where('category', $cat_id)->latest()->get();
        return view('books.list_books', compact('books'));
    }
    public function ListLesson(Request $request)
    {
        $lessons = LessonsModel::latest()->get();
        return view('lessons.list_lessons', compact('lessons'));
    }

    public function ListSermons(Request $request)
    {
        $muxaadarooyinka = SermonsModel::whereHas('SheekhInfo')->latest()->get();
        return view('sermons.list_sermons', compact('muxaadarooyinka'));
    }

    public function AddBookForm(Request $request)
    {
        $sheekhs = SheekhsModel::get();
        $categories = LessonCategoriesModel::where('is_active', true)->get();
        return view('books.add_form', compact('sheekhs', 'categories'));
    }
    public function AddLessonForm(Request $request, $book_id)
    {
        $book = BooksModel::where('id', $book_id)->get();
        if ($book == null || $book->count() <= 0) {
            abort(404);
        }

        $book = $book[0];
        return view('lessons.add_form', compact('book'));
    }

    public function AddSermonForm(Request $request)
    {
        $sheekhs = SheekhsModel::get();
        return view('sermons.add_form', compact('sheekhs'));
    }
    public function EditLessonForm(Request $request, $book_id, $lesson_id)
    {
        $lesson = LessonsModel::where("id", $lesson_id)->get();
        abort_if($lesson == null || $lesson->count() <= 0, 404);
        $book = BooksModel::where('id', $book_id)->get();
        abort_if($book == null || $book->count() <= 0, 404);

        $lesson = $lesson[0];
        $book = $book[0];
        return view('lessons.edit_lesson', compact('lesson', 'book'));
    }

    public function openCategoryPage(Request $request)
    {
        $categories = LessonCategoriesModel::where('is_active', true)->get();
        return view('books.category', compact('categories'));
    }

    public function AddBookToDB(Request $request)
    {
        $rules = [
            "sheekha_soojediyay" => "required|integer|exists:sheekhs,id",
            "magaca_buuga" => "required|string|max:255",
            "qoraaga_buuga" => "nullable|string|max:255",
            "faahfaahinta_buuga" => "nullable|string|max:255|min:3",
            "tirada_saxfada_buuga" => "nullable|numeric|max:99999|min:1",
            "taariikhda_buuga_la_qoray" => "nullable|date|before:now",
            "buuga_casharkiisa_socdo" => "nullable|in:on,off",
            "book_category" => "required|integer|exists:lesson_categories,id",
        ];

        $data = $request->validate($rules);

        $BookModel = new BooksModel();
        $data["buuga_casharkiisa_socdo"] = $request->buuga_casharkiisa_socdo == "on";

        $success = $BookModel->addNewBook($data);

        if ($success) {
            return Redirect::back()->with('success', 'successfully added new book');
        }

        return Redirect::back()->withErrors(['errorMessage' => $BookModel->errorMessage]);
    }
    public function AddCategoryBook(Request $request)
    {
        $rules = [
            "parent_category" => "required|integer",
            "category_name" => "required|string|max:255|unique:lesson_categories,category_name",
        ];

        $data = $request->validate($rules);

        $parent = null;
        if ($request->parent_category != -1) {
            $parent = LessonCategoriesModel::where('id', $request->parent_category)->get();
            if ($parent == null || $parent->count() <= 0) {
                return Redirect::back()->withErrors(['errorMessage' => 'The selected parent category is not valid']);
            }
        }

        $CategoryModel = new LessonCategoriesModel();

        $is_added = $CategoryModel->addCategory($data);
        if ($is_added) {
            return Redirect::back()->with('success', 'successfully added new category');
        } else {
            return Redirect::back()->withErrors(['errorMessage' => $CategoryModel->errorMessage]);
        }

    }

    public function AddSheekhToDB(Request $request)
    {
        $rules = [
            "magaca_sheekha" => "required|string|max:255",
            "emailka_sheekha" => "required|email|max:75",
            "wadanka_sheekha" => "required|string|max:75",
        ];

        $data = $request->validate($rules);

        $SheekhModel = new SheekhsModel();

        $success = $SheekhModel->addNewSheekh($data);
        if ($success) {
            return Redirect::back()->with('success', 'successfully added new sheekh');
        }

        return Redirect::back()->withErrors(['errorMessage' => $SheekhModel->errorMessage]);
    }

    public function AddLessonToDB(Request $request, $book_id)
    {

        $book = BooksModel::where('id', $book_id)->get();
        if ($book == null || $book->count() <= 0) {
            abort(404);
        }

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
                    "data" => [],
                ]);
            }
            $data = $validator->validated();
        } else {
            $data = $request->validate($rules);
        }

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
                            "data" => [],
                        ]);
                    } else {
                        return Redirect::back()->with('success', 'successfully added new sheekh');
                    }

                } else {

                    if ($request->expectsJson()) {
                        return FacadesResponse::json([
                            "errorMessage" => $LessonModel->errorMessage,
                            "isSuccess" => false,
                            "data" => [],
                        ]);
                    } else {
                        return Redirect::back()->withErrors(['errorMessage' => $LessonModel->errorMessage]);
                    }

                }
            } catch (\Throwable$th) {
                if ($request->expectsJson()) {
                    return FacadesResponse::json([
                        "errorMessage" => $th->getMessage(),
                        "isSuccess" => false,
                        "data" => [],
                    ]);
                } else {
                    return Redirect::back()->withErrors(['errorMessage' => $th->getMessage()]);
                }

            }
        } else {
            if ($request->expectsJson()) {
                return FacadesResponse::json([
                    "errorMessage" => 'The lesson audio file is not given',
                    "isSuccess" => false,
                    "data" => [],
                ]);
            } else {
                Redirect::back()->withErrors(['errorMessage' => 'The lesson audio file is not given']);
            }

        }
    }
    public function editLesson(Request $request)
    {

        $rules = [
            "cinwaanka_casharka" => "required|string|max:255",
            "numbarka_casharka" => "required|integer",
            "fileka_casharka" => "nullable|file|mimes:audio/mpeg,mp3,wav",
            "lesson" => "required|integer|exists:lessons,id",
            "book" => "required|integer|exists:lessons,book_id",
        ];

        if ($request->expectsJson()) {
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return FacadesResponse::json([
                    "errorMessage" => $validator->errors()->first(),
                    "isSuccess" => false,
                    "data" => [],
                ]);
            }
            $data = $validator->validated();
        } else {
            $data = $request->validate($rules);
        }

        $lesson = LessonsModel::where([
            ["id", $data["lesson"]],
            ["book_id", $data["book"]],
        ])->get();
        $book = BooksModel::where('id', $data["book"])->get();

        if ($lesson == null || $lesson->count() <= 0 || $book == null || $book->count() <= 0) {
            FacadesResponse::json([
                "errorMessage" => "The lesson you are tying to edit could not be found",
                "isSuccess" => false,
                "data" => [],
            ]);
        }
        $lesson = $lesson[0];
        $book = $book[0];
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

                $data["file_casharka"] = $fileurl;
                $data["file_size"] = $size;
            } catch (\Throwable$th) {
                if ($request->expectsJson()) {
                    return FacadesResponse::json([
                        "errorMessage" => $th->getMessage(),
                        "isSuccess" => false,
                        "data" => [],
                    ]);
                } else {
                    return Redirect::back()->withErrors(['errorMessage' => $th->getMessage()]);
                }

            }
        }
        $LessonModel = new LessonsModel();
        $success = $LessonModel->updateLesson($data, $book, $lesson);
        if ($success) {
            if ($request->expectsJson()) {
                return FacadesResponse::json([
                    "errorMessage" => 'successfully added new sheekh',
                    "isSuccess" => true,
                    "data" => [],
                ]);
            } else {
                return Redirect::back()->with('success', 'successfully added new sheekh');
            }

        } else {

            if ($request->expectsJson()) {
                return FacadesResponse::json([
                    "errorMessage" => $LessonModel->errorMessage,
                    "isSuccess" => false,
                    "data" => [],
                ]);
            } else {
                return Redirect::back()->withErrors(['errorMessage' => $LessonModel->errorMessage]);
            }

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
                    "data" => [],
                ]);
            }
            $data = $validator->validated();
        } else {
            $data = $request->validate($rules);
        }

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
                            "data" => [],
                        ]);
                    } else {
                        return Redirect::back()->with('success', 'successfully added new sheekh');
                    }

                } else {

                    if ($request->expectsJson()) {
                        return FacadesResponse::json([
                            "errorMessage" => $SermonModel->errorMessage,
                            "isSuccess" => false,
                            "data" => [],
                        ]);
                    } else {
                        return Redirect::back()->withErrors(['errorMessage' => $SermonModel->errorMessage]);
                    }

                }
            } catch (\Throwable$th) {
                if ($request->expectsJson()) {
                    return FacadesResponse::json([
                        "errorMessage" => $th->getMessage(),
                        "isSuccess" => false,
                        "data" => [],
                    ]);
                } else {
                    return Redirect::back()->withErrors(['errorMessage' => $th->getMessage()]);
                }

            }
        } else {
            if ($request->expectsJson()) {
                return FacadesResponse::json([
                    "errorMessage" => 'The lesson audio file is not given',
                    "isSuccess" => false,
                    "data" => [],
                ]);
            } else {
                Redirect::back()->withErrors(['errorMessage' => 'The muxaadaro audio file is not given']);
            }

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
            "data" => $sheekhs,
        ]);
    }
    public function openAPIGetSheekhBookCategories($sheekh_id)
    {
        $sheekh = SheekhsModel::where('id', $sheekh_id)->get();
        $categories = LessonCategoriesModel::where('is_active', true)->whereDoesntHave('parent')->get();
        // $_books = [];
        if ($sheekh != null && $sheekh->count() > 0) {
            // $books = BooksModel::where([
            //     ['sheekh_id', $sheekh_id],
            // ])->get();
            foreach ($categories as $key => $category) {
                // if ($category != null && $category->count() > 0) {
                //     $category[0]->Books;
                //     $category[0]->Parent;
                //     array_push($categories, $category[0]);
                // }
                // unset($books[$key]->Casharada);
                $category->Parent;
                $_books = $category->Books->where('sheekh_id', $sheekh_id);
                unset($categories[$key]->Books);
                $categories[$key]->books = $_books;
            }
            // $sheekh = $sheekh[0];

        }

        return FacadesResponse::json([
            "errorMessage" => null,
            "isSuccess" => true,
            "data" => $categories,
        ]);
    }

    public function openAPIgetGivenSheekhCategoryBooks($sheekh_id, $category_id)
    {
        $sheekh = SheekhsModel::where('id', $sheekh_id)->get();
        if ($sheekh != null && $sheekh->count() > 0) {
            $books = $sheekh[0]->Books->where('category', $category_id);

            $_books = [];
            foreach ($books as $key => $book) {
                $books[$key]["lesson_count"] = $book->Casharada->count();
                unset($books[$key]->Casharada);
                array_push($_books, $book);
            }

            unset($sheekh[0]->Books);
            $sheekh[0]->books = $_books;
        }

        return FacadesResponse::json([
            "errorMessage" => null,
            "isSuccess" => true,
            "data" => $sheekh[0],
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
            "data" => $books,
        ]);
    }
    public function openAPIGetLessonsList()
    {
        $lessons = LessonsModel::with('SheekhInfo', 'BookInfo')->latest()->OrderBy('lesson_number')->get();

        return FacadesResponse::json([
            "errorMessage" => null,
            "isSuccess" => true,
            "data" => $lessons,
        ]);
    }

    public function openAPISermonsList()
    {
        $sermons = SermonsModel::whereHas('SheekhInfo')->latest()->get();

        foreach ($sermons as $key => $sermon) {
            $sermon->sheekhInfo;
        }

        return FacadesResponse::json([
            "errorMessage" => null,
            "isSuccess" => true,
            "data" => $sermons,
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
            "data" => $sheekh,
        ]);
    }
    public function getCategoriesList(Request $request)
    {
        $categories = LessonCategoriesModel::where('is_active', true)->get();

        foreach ($categories as $key => $category) {
            $books = $category->Books;
            $parent = $category->Parent;
        }
        return FacadesResponse::json([
            "errorMessage" => null,
            "isSuccess" => true,
            "data" => $categories,
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
            "data" => $book,
        ]);
    }
}
