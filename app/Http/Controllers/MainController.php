<?php

namespace App\Http\Controllers;

use App\models\BooksModel;
use App\models\LessonCategoriesModel;
use App\models\LessonsModel;
use App\models\SermonsModel;
use App\models\SheekhsModel;
use App\Services\BookServices;
use App\Services\CategoriesServices;
use App\Services\LessonServices;
use App\Services\SermonServices;
use App\Services\SheekhServices;
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

    public function ListSheekhs(Request $request, SheekhServices $sheekhServices)
    {
        $sheekhs = $sheekhServices->getLatestsheikhsList($request);
        return view('sheekhs.list_sheekhs', compact('sheekhs'));
    }

    public function ListBooks(Request $request, BookServices $bookServices)
    {
        $books = $bookServices->getLatestBooks($request);
        return view('books.list_books', compact('books'));
    }

    public function openBooksFromCategory(Request $request, $cat_id, BookServices $bookServices)
    {
        $books = $bookServices->getGivenCategoryBooks($request, $cat_id);
        return view('books.list_books', compact('books'));
    }
    public function ListLesson(Request $request, LessonServices $lessonServices)
    {
        $lessons = $lessonServices->getLatestLessons($request);
        return view('lessons.list_lessons', compact('lessons'));
    }

    public function ListSermons(Request $request, SermonServices $sermonServices)
    {
        $muxaadarooyinka = $sermonServices->getLatestSermons($request);
        return view('sermons.list_sermons', compact('muxaadarooyinka'));
    }

    public function AddBookForm(Request $request, SheekhServices $sheekhServices, CategoriesServices $categoriesServices)
    {
        $sheekhs = $sheekhServices->getLatestsheikhsList($request);
        $categories = $categoriesServices->getCategoriesList($request);
        return view('books.add_form', compact('sheekhs', 'categories'));
    }
    public function AddLessonForm(Request $request, $book_id, BookServices $bookServices)
    {
        $book = $bookServices->getBookById($request, $book_id);
        abort_if(!$book, 404);
        return view('lessons.add_form', compact('book'));
    }

    public function AddSermonForm(Request $request, SheekhServices $sheekhServices)
    {
        $sheekhs = $sheekhServices->getLatestsheikhsList($request);
        return view('sermons.add_form', compact('sheekhs'));
    }
    public function EditLessonForm(Request $request, $book_id, $lesson_id, LessonServices $lessonServices, BookServices $bookServices)
    {
        $lesson = $lessonServices->getLessonById($request, $lesson_id);
        $book = $bookServices->getBookById($request, $book_id);
        abort_if(!$lesson, 404);

        abort_if(!$book, 404);

        return view('lessons.edit_lesson', compact('lesson', 'book'));
    }

    public function openCategoryPage(Request $request, CategoriesServices $categoriesServices)
    {
        $categories = $categoriesServices->getCategoriesList($request);
        return view('books.category', compact('categories'));
    }

    public function AddBookToDB(Request $request, BookServices $bookServices)
    {
        $book = $bookServices->addNewBook($request);
        if ($book) {
            return Redirect::back()->with('success', 'Added New book successfuly');
        }
        return Redirect::back()->withErrors(['errorMessage' => $bookServices->getMessage()])->withInput();
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
        ])->get()->first();
        $book = BooksModel::where('id', $data["book"])->get()->first();

        if (!$lesson) {
            FacadesResponse::json([
                "errorMessage" => "The lesson you are tying to edit could not be found",
                "isSuccess" => false,
                "data" => [],
            ]);
        }
        // $lesson = $lesson[0];
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

    public function openAPIGetSheekhList(Request $request, SheekhServices $sheekhServices)
    {
        return $sheekhServices->getLatestsheikhsList($request);
    }
    public function openAPIGetSheekhBookCategories(Request $request, $sheekh_id, SheekhServices $sheekhServices)
    {
        return $sheekhServices->getSheekhCategories($request, $sheekh_id);
    }

    public function openAPIgetGivenSheekhCategoryBooks(Request $request, $sheekh_id, $category_id, SheekhServices $sheekhServices)
    {
        return $sheekhServices->getGivenSheekhCategoryBooks($request, $sheekh_id, $category_id);
    }

    public function openAPIGetBooksList(Request $request, BookServices $bookServices)
    {
        return $bookServices->getLatestBooks($request);
    }
    public function openAPIGetLessonsList(Request $request, LessonServices $lessonServices)
    {
        return $lessonServices->getLatestLessons($request);
    }

    public function openAPISermonsList(Request $request, SermonServices $sermonServices)
    {
        return $sermonServices->getLatestSermons($request);
    }
    public function openAPIGetGivenSheekh(Request $request, $sheekh_id, SheekhServices $sheekhServices)
    {
        return $sheekhServices->getGivenSheekhDetails($request, $sheekh_id);
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
    public function openAPIGetGivenBook(Request $request, $book_id, LessonServices $lessonServices)
    {
        return $lessonServices->getGivenBookLessons($request, $book_id);
    }

    public function viewBookLessons(Request $request, $book_id)
    {
        $lessons = LessonsModel::where('book_id', $book_id)->get();

        return view('lessons.list_lessons', compact('lessons'));
    }
}
