<?php
namespace App\Services;

use App\models\BooksModel;
use Drongotech\ResponseParser\DefaultService;

class BookServices extends DefaultService
{

    public function getLatestBooks($request)
    {
        $this->request = $request;
        $is_json = $this->ResponseType();

        $books = BooksModel::with('SheekhInfo')->limit(20)->latest()->get();

        return $is_json ? $this->Parse(false, 'succcess', $books) : $books;
    }

    public function getGivenCategoryBooks($request, $cat_id)
    {
        $this->request = $request;
        $is_json = $this->ResponseType();

        $books = BooksModel::where('category', $cat_id)->latest()->get();

        return $is_json ? $this->Parse(false, 'success', $books) : $books;
    }

    public function getBookById($request, $book_id)
    {
        $this->request = $request;
        $is_json = $this->ResponseType();

        $book = BooksModel::where('id', $book_id)->with('Lessons')->get()->first();

        return $is_json ? $this->Parse(false, 'success', $book) : $book;

    }

    public function addNewBook($request)
    {
        $this->request = $request;
        $is_json = $this->ResponseType();

        $this->rules = [
            "sheekha_soojediyay" => "required|integer|exists:sheekhs,id",
            "magaca_buuga" => "required|string|max:255",
            "qoraaga_buuga" => "nullable|string|max:255",
            "faahfaahinta_buuga" => "nullable|string|max:255|min:3",
            "tirada_saxfada_buuga" => "nullable|numeric|max:99999|min:1",
            "taariikhda_buuga_la_qoray" => "nullable|date|before:now",
            "buuga_casharkiisa_socdo" => "nullable|in:on,off",
            "book_category" => "required|integer|exists:lesson_categories,id",
        ];

        $this->CustomValidate();
        if ($this->has_failed) {
            return $is_json ? $this->Parse(true, $this->getMessage()) : false;
        }
        $data = $this->ValidatedData();

        $BookModel = new BooksModel();
        $data["buuga_casharkiisa_socdo"] = $request->buuga_casharkiisa_socdo == "on";

        $success = $BookModel->addNewBook($data);

        if ($success) {
            return $is_json ? $this->Parse(false, 'success', $success) : $success;
        }

        $this->setError($m = $BookModel->getMessage());
        return $is_json ? $this->Parse(true, $m) : false;

    }
}
