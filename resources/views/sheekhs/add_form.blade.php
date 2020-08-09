@extends('layouts.main_layout')

@section('pageTitle')
Sheekh Cusub
@endsection

@section('parentPage')
Sheekh
@endsection

@section('content')
<div class="row">
    <div class="col-md-2 col-lg-2"></div>
    <div class="col-md-8 col-lg-8">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">SHEEKH CUSUB</h4>
                <p class="card-title-desc">
                    Diiwaan galinta sheekh cusub
                </p>
                @if (Session::has('success'))
                    
                <div class="alert alert-success"> {{Session::get('success')}} </div>
                @endif
                @error('errorMessage')
                    <div class="alert alert-danger">{{$message}}</div>
                @enderror
                    
                <form class="form" method="POST">
                    @csrf
                    <div class="mb-4">
                        <input class="form-control" name="magaca_sheekha" type="text" placeholder="Magaca Sheekh"
                        value="{{old('magaca_sheekha')}}">
                    </div>
                    @error('magaca_sheekha')
                    <div class="alert alert-danger">
                        {{$message}}
                    </div>
                    @enderror
                    <div class="mb-4">
                        <input class="form-control" name="emailka_sheekha" type="email" placeholder="Emailka Sheekh"
                        value="{{old('emailka_sheekha')}}">
                    </div>
                    @error('emailka_sheekha')
                    <div class="alert alert-danger">
                        {{$message}}
                    </div>
                    @enderror
                    <div class="mb-4">
                        <input class="form-control"  name="wadanka_sheekha" type="text" placeholder="Wadanka uu joogo Sheekha"
                        value="{{old('wadanka_sheekha')}}">
                    </div>
                    @error('wadanka_sheekha')
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
