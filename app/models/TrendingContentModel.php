<?php

namespace App\models;

use App\CustomClasses\ResponseParser;
use Illuminate\Database\Eloquent\Model;

class TrendingContentModel extends Model
{
    //
    protected $table  ='trending_content';
    protected $fillable =[
        'trending_id',
        'trending_type',
        'is_active',
        'trend_image',
        'created_by'
    ];

    public function createOrUpdateContent($data){
        try {
            $content = $this->updateOrCreate([
                'id' => $data['trend_id'] ?? -1,
            ], $data);
            $active_trends = $this->where([
                ['is_active', true],
                ['id', '!=', $content->id]
            ])->get();
            foreach ($active_trends as $key => $trend) {
                $trend->update([
                    'is_active' => false,
                ]);
            }
            return ResponseParser::Parse(true, null, $content);
        } catch (\Throwable $th) {
            return  ResponseParser::Parse(false, $th->getMessage());
        }
    }

    public function TrendingContent(){
        if($this->trending_type == 1)
            return $this->belongsTo(SheekhsModel::class, 'trending_id');
        else  if($this->trending_type == 2)
            return $this->belongsTo(BooksModel::class, 'trending_id')->with('SheekhInfo');
        else  if($this->trending_type == 3)
            return $this->belongsTo(LessonsModel::class, 'trending_id')->with('BookInfo', 'SheekhInfo');
        else 
            return $this->belongsTo(SermonsModel::class, 'trending_id')->with('SheekhInfo');
    }
}
