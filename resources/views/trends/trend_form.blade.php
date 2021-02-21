@extends('layouts.main_layout')

@section('pageTitle')
New Trend
@endsection

@section('parentPage')
Trends
@endsection

@section('content')
<div class="row">
    <div class="col-md-3 col-lg-3">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Sheekh Trend</h4>
                <p class="card-title-desc">
                    Adding new trending
                </p>
                @if (Session::has('success'))
                    
                <div class="alert alert-success"> {{Session::get('success')}} </div>
                @endif
                @error('errorMessage')
                    <div class="alert alert-danger">{{$message}}</div>
                @enderror
                    
                <form class="form" method="POST" ref="sheekhTrend">
                    @csrf
                    <div class="mb-4">
                        <select name="trending_id"  class="form-control">
                            @foreach ($sheekhs as $sheekh)
                                <option value="{{$sheekh->id}}">{{$sheekh->sheekh_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <input type="hidden" name="trending_type"  value="1">
                    <div class="mb-4">
                        <input type="file" name="trend_image" id=""  class="form-control">
                    </div>
                    <div class="mb-4">
                        <input class="form-control btn btn-primary" type="submit" value="Add Trend" 
                        @click.prevent="addTrend(1)">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-lg-3">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Book Trend</h4>
                <p class="card-title-desc">
                    Adding new trending
                </p>
                @if (Session::has('success'))
                    
                <div class="alert alert-success"> {{Session::get('success')}} </div>
                @endif
                @error('errorMessage')
                    <div class="alert alert-danger">{{$message}}</div>
                @enderror
                    
                <form class="form" method="POST" ref="bookTrend">
                    @csrf
                    <div class="mb-4">
                        <select name="trending_id" id="" class="form-control">
                            @foreach ($books as $book)
                                <option value="{{$book->id}}">{{$book->book_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <input type="hidden" name="trending_type"  value="2">
                    <div class="mb-4">
                        <input type="file" name="trend_image" id=""  class="form-control">
                    </div>
                    <div class="mb-4">
                        <input class="form-control btn btn-primary" type="submit" value="Add Trend"
                        @click.prevent="addTrend(2)">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-lg-3">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Lesson Trend</h4>
                <p class="card-title-desc">
                    Adding new trending
                </p>
                @if (Session::has('success'))
                    
                <div class="alert alert-success"> {{Session::get('success')}} </div>
                @endif
                @error('errorMessage')
                    <div class="alert alert-danger">{{$message}}</div>
                @enderror
                    
                <form class="form" method="POST" ref="lessonTrend">
                    @csrf
                    <div class="mb-4">
                        <select name="trending_id" id="" class="form-control">
                            @foreach ($lessons as $lesson)
                                <option value="{{$lesson->id}}">{{$lesson->lesson_title}}</option>
                            @endforeach
                        </select>
                    </div>
                    <input type="hidden" name="trending_type"  value="3">
                    <div class="mb-4">
                        <input type="file" name="trend_image" id=""  class="form-control">
                    </div>
                    <div class="mb-4">
                        <input class="form-control btn btn-primary" type="submit" value="Add Trend" 
                        @click.prevent="addTrend(3)">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-lg-3">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Lesson Trend</h4>
                <p class="card-title-desc">
                    Adding new trending
                </p>
                @if (Session::has('success'))
                    
                <div class="alert alert-success"> {{Session::get('success')}} </div>
                @endif
                @error('errorMessage')
                    <div class="alert alert-danger">{{$message}}</div>
                @enderror
                    
                <form class="form" method="POST" ref="sermonTrend">
                    @csrf
                    <div class="mb-4">
                        <select name="trending_id" id="" class="form-control">
                            @foreach ($sermons as $sermon)
                                <option value="{{$sermon->id}}">{{$sermon->sermon_title}}</option>
                            @endforeach
                        </select>
                    </div>
                    <input type="hidden" name="trending_type"  value="4">
                    <div class="mb-4">
                        <input type="file" name="trend_image" id=""  class="form-control">
                    </div>
                    <div class="mb-4">
                        <input class="form-control btn btn-primary" type="submit" value="Add Trend" 
                        @click.prevent="addTrend(4)">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection


@section('scripts')
<script>
    window.token = "{{Auth::user()->api_token}}"
</script>
    <script src="/js/trends.js"></script>
@endsection