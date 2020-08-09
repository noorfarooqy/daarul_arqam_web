@extends('layouts.main_layout')

@section('pageTitle')
Cashar Cusub
@endsection

@section('parentPage')
Casharada
@endsection

@section('content')
<div class="row">
    <div class="col-md-2 col-lg-2"></div>
    <div class="col-md-8 col-lg-8">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">CASHAR CUSUB</h4>
                <p class="card-title-desc">
                    Diiwaan galinta Cashar cusub buuga {{$book->book_name}}
                </p>
                @if (Session::has('success'))
                    
                <div class="alert alert-success"> {{Session::get('success')}} </div>
                @endif
                @error('errorMessage')
                    <div class="alert alert-danger">{{$message}}</div>
                @enderror
                    
                <form class="form" method="POST" action="/casharada/new/{{$book->id}}"
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
                        value="{{$book->Casharada->count()+1}}">
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
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-2 col-lg-2"></div>
</div>

@endsection
