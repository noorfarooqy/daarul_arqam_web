@extends('layouts.main_layout')

@section('pageTitle')
Muxaadaro Cusub
@endsection

@section('parentPage')
Muxaadaro
@endsection

@section('content')
<div class="row">
    <div class="col-md-2 col-lg-2"></div>
    <div class="col-md-8 col-lg-8">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">MUXAADARO AMA QUDBA CUSUB</h4>
                <p class="card-title-desc">
                    Diiwaan galinta muxaadaro cusub
                </p>
                

                <sermon-form v-bind="{sheekhList: sheekhList}"></sermon-form>
                
            </div>
        </div>
    </div>
    <div class="col-md-2 col-lg-2"></div>
</div>

@endsection


@section('scripts')
<script>
    window.api_token = "{{Auth::user()->api_token}}";

</script>
<script src="/js/newSermon.js" type="text/javascript"></script>
@endsection