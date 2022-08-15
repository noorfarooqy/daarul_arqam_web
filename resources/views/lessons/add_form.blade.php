@extends('layouts.main_layout')

@section('pageTitle')
Cashar Cusub
@endsection

@section('parentPage')
Lessons
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
                
                
                
                {{-- <form class="form" method="POST" action="/Lessons/new/{{$book->id}}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <input class="form-control" name="cinwaanka_casharka" type="text" placeholder="Cinwaanka casharka"
                        value="{{old('cinwaanka_casharka')}}">
                    </div>
                    @error('cinwaanka_casharka')
                    <div class="alert alert-danger">
                        {{$message}}
                    </div>
                    @enderror
                    <div class="mb-4">
                        <label for="">Numberka casharka</label>
                        @if (old('numbarka_casharka'))
                            <input class="form-control" name="numbarka_casharka" type="number" placeholder="Numberka casharka"
                        value="{{old('numbarka_casharka')}}">
                        @else
                        <input class="form-control" name="numbarka_casharka" type="number" placeholder="Numberka casharka"
                        value="{{$book->Lessons->count()+1}}">
                        @endif
                        
                    </div>
                    @error('numbarka_casharka')
                    <div class="alert alert-danger">
                        {{$message}}
                    </div>
                    @enderror
                    <div class="mb-4">
                        <label for="">Fileka Casharka</label>
                        <input class="form-control" name="fileka_casharka" type="file" placeholder="Numberka casharka"
                        value="{{old('fileka_casharka')}}">
                    </div>
                    @error('fileka_casharka')
                    <div class="alert alert-danger">
                        {{$message}}
                    </div>
                    @enderror
                    <div class="mb-4">
                        <input class="form-control btn btn-primary" type="submit" value="Add Sheekh">
                    </div>
                </form> --}}
            </div>
        </div>
        <div class="card-footer">
            <button class="btn btn-secondary" @click.prevent="AddNewLesson">
                    <i class="fas fa-plus"></i> Kudar cashar kale
                </button>
        </div>
    </div>
    <div class="col-md-2 col-lg-2"></div>
</div>

@endsection

@section('scripts')
<script>
    window.bookId = "{{$book->id}}";
    window.api_token = "{{Auth::user()->api_token}}";
    window.lessonNumber = "{{($book->Lessons->count()+1)}}";

</script>
@php
    $hash = hash('md5', public_path('/js/newCashar.js'));
@endphp
<script src="/js/newCashar.js?{{$hash}}" type="text/javascript"></script>
@endsection