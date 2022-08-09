<?php

namespace App\Http\Controllers;

use App\CustomClasses\ResponseParser;
use App\models\BooksModel;
use App\models\LessonsModel;
use App\models\SermonsModel;
use App\models\SheekhsModel;
use App\models\TrendingContentModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class TrendingContentController extends Controller
{
    //
    public function createOrUpdateTrendingContent(Request $request){
        $user = $request->user();
        $rules = [
            'trending_id' => "required|integer",
            'trending_type' => "required|integer|in:1,2,3,4",
            'trend_image' => "required|file:mimes:jpg,png,jpeg",
        ];

        $Validator = Validator::make($request->all(), $rules);
        if($Validator->fails()){
            return ResponseParser::Parse(false, $Validator->errors()->all());
        }
        $data = $Validator->validated();
        $trend = null;
        if($data["trending_type"] == 1){
            $trend = SheekhsModel::where('id', $data['trending_id'])->get();
        }
        else  if($data["trending_type"] == 2){
            $trend = BooksModel::where('id', $data['trending_id'])->get();
        }
        else  if($data["trending_type"] == 3){
            $trend = LessonsModel::where('id', $data['trending_id'])->get();
        }
        else{
            $trend = SermonsModel::where('id', $data['trending_id'])->get();
        }
        if($trend == null || $trend->count() <= 0){
            return ResponseParser::Parse(false, 'The trending content is not valid');
        }
        try {
            $path = "uploads/trending/";
            $file_path = Storage::disk('public')->putFile($path, $request->trend_image);
            $data["trend_image"] = "/storage/$file_path";
        } catch (\Throwable $th) {
            return ResponseParser::Parse(false, $th->getMessage());
        }
        $data["created_by"] = $user->id;

        $TrendingContentModel = new TrendingContentModel();
        return $TrendingContentModel->createOrUpdateContent($data);

    }

    public function getTrendingContentDetail($content_id){
        $content = TrendingContentModel::where('id', $content_id)->latest()->get()->last();
        if($content == null || $content->count() <=0){
            return ResponseParser::Parse(false, 'Trending content not found');
        }
        $trend = $content->TrendingContent;
        if($trend == null || $trend->count() <= 0){
            return ResponseParser::Parse(false, 'Trending content does not exist');
        }
        return ResponseParser::Parse(true, null,$content);
    }
    public function getActiveTrend(Request $request){
        $trend = TrendingContentModel::where('is_active', true)->latest()->get()->last();
        if($trend == null || $trend->count() <=0){
            return ResponseParser::Parse(false, 'No active trends');
        }
        $trend->TrendingContent;
        return ResponseParser::Parse(true, null, $trend);
    }


    //views

    public function viewTrendForm(Request $request){
        $sheekhs = SheekhsModel::get();
        $books = BooksModel::get();
        $sermons = SermonsModel::get();
        $lessons = LessonsModel::get();
        return view('trends.trend_form', compact('sheekhs', 'books', 'sermons', 'lessons'));
    }

    public function viewTrendList(Request $request){
        return view('trends.trend_form');
    }
}
