@extends('layouts.main_layout')

@section('pageTitle')
Cashar Cusub
@endsection

@section('parentPage')
Casharada
@endsection

@section('content')
<div class="row">
    <div class="col-md-2 col-lg-2">
        
    </div>
    <div class="col-md-7 col-lg-7">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">CASHAR CUSUB</h4>
                <p class="card-title-desc">
                    Diiwaan galinta Cashar cusub buuga {{$book->book_name}}
                </p>

                

                <div v-for="(Lesson,lkey) in Lessons" :key="lkey">
                    <lesson-form v-bind="{Lesson:Lesson}"></lesson-form>
                </div>
                
                
            </div>
        </div>
    </div>
    <div class="col-md-2 col-lg-2"></div>
</div>

@endsection

@section('scripts')
<script>
    window.bookId = "{{$book->id}}";
    window.api_token = "{{Auth::user()->api_token}}";
    window.lessonNumber = "{{$lesson->lesson_number}}";
    window.lessonId = "{{$lesson->id}}";
    window.lessonTitle = "{{$lesson->lesson_title}}";

</script>
@php
    $hash = hash('md5', public_path('/js/editCashar.js'));
@endphp
<script src="/js/editCashar.js?{{$hash}}" type="text/javascript"></script>
@endsection