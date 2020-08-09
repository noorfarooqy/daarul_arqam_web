@extends('layouts.main_layout')

@section('pageTitle')
Buug Cusub
@endsection

@section('parentPage')
Buug
@endsection

@section('content')
<div class="row">
    <div class="col-md-2 col-lg-2"></div>
    <div class="col-md-8 col-lg-8">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">BUUG CUSUB</h4>
                <p class="card-title-desc">
                    Diiwaan galinta Buug cusub
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
                        <input class="form-control" name="magaca_buuga" type="text" placeholder="Magaca buugga"
                            value="{{old('magaca_buuga')}}">
                    </div>
                    @error('magaca_buuga')
                    <div class="alert alert-danger">
                        {{$message}}
                    </div>
                    @enderror
                    <div class="mb-4">
                        <select name="sheekha_soojediyay" class="form-control" id="">
                            <option value="-1" >Sheekha soojeediyay</option>
                            @foreach ($sheekhs as $sheekh)
                                
                                @if (old('magaca_buuga') == $sheekh->id)
                                    <option value="{{$sheekh->id}}" selected>{{$sheekh->sheekh_name}}</option>
                                @else
                                    <option value="{{$sheekh->id}}">{{$sheekh->sheekh_name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    @error('sheekha_soojediyay')
                    <div class="alert alert-danger">
                        {{$message}}
                    </div>
                    @enderror
                    <div class="mb-4">
                        <input class="form-control" name="qoraaga_buuga" type="text" placeholder="Qoraaga buuga"
                            value="{{old('qoraaga_buuga')}}">
                    </div>
                    @error('qoraaga_buuga')
                    <div class="alert alert-danger">
                        {{$message}}
                    </div>
                    @enderror

                    <div class="mb-4">
                        <textarea class="form-control" name="faahfaahinta_buuga" type="text"
                            placeholder="Faahfaahin gaabin">{{old('faahfaahinta_buuga')}}</textarea>
                    </div>
                    @error('faahfaahinta_buuga')
                    <div class="alert alert-danger">
                        {{$message}}
                    </div>
                    @enderror
                    <div class="mb-4">
                        <input class="form-control" name="tirada_saxfada_buuga" type="number" min="1" max="9999"
                            placeholder="tirada saxfooyinka buuga" value="{{old('tirada_saxfada_buuga')}}">
                    </div>
                    @error('tirada_saxfada_buuga')
                    <div class="alert alert-danger">
                        {{$message}}
                    </div>
                    @enderror
                    <div class="mb-4">
                        <label for="">Taariikhda buuga la qoray</label>
                        <input class="form-control" name="taariikhda_buuga_la_qoray" type="date"
                            placeholder="Taariikhda buuga la qoray" value="{{old('taariikhda_buuga_la_qoray')}}">
                    </div>
                    @error('taariikhda_buuga_la_qoray')
                    <div class="alert alert-danger">
                        {{$message}}
                    </div>
                    @enderror
                    <div class="mb-4">
                        <div class="custom-control custom-checkbox mb-2">
                            @if (old('buuga_casharkiisa_socdo'))
                            <input type="checkbox" name="buuga_casharkiisa_socdo" class="custom-control-input" id="customCheck1" checked="">
                            <label class="custom-control-label" for="customCheck1">Casharada buuga way socdaan</label>
                            @else
                            <input type="checkbox" name="buuga_casharkiisa_socdo" class="custom-control-input" id="customCheck1" >
                            <label class="custom-control-label" for="customCheck1">Casharada buuga way socdaan</label>
                            @endif
                            
                        </div>
                    </div>
                    @error('buuga_casharkiisa_socdo')
                    <div class="alert alert-danger">
                        {{$message}}
                    </div>
                    @enderror
                    <div class="mb-4">
                        <input class="form-control btn btn-primary" type="submit" value="Add Book">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-2 col-lg-2"></div>
</div>

@endsection
