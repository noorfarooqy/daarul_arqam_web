@extends('layouts.main_layout')

@section('content')

<div class="row">
    <div class="col-lg-4">
        <a href="/sheekh/list">
            <div class="card border border-primary">
            <div class="card-header bg-transparent border-primary">
                <h5 class="my-0 text-primary"><i class="mdi mdi-bullseye-arrow mr-3"></i>SHEEKHS</h5>
            </div>
            <div class="card-body">
                <a href="/sheekh/list"><h5 class="card-title mt-0">LISKA CULIMADA</h5></a>
                <p class="card-text">

                </p>
            </div>
        </div>
        </a>
    </div>
    <div class="col-lg-4">
        <a href="/books/list">
            <div class="card border border-success">
            <div class="card-header bg-transparent border-success">
                <h5 class="my-0 text-success"><i class="mdi mdi-check-all mr-3"></i>BUUGAAGTA</h5>
            </div>
            <div class="card-body">
                <h5 class="card-title mt-0">LIISKA BUUGAAGTA</h5>
                <p class="card-text">

                </p>
            </div>
        </div>
        </a>
    </div>

    <div class="col-lg-4">
        <a href="/books/list">
            <div class="card border border-danger">
            <div class="card-header bg-transparent border-danger">
                <h5 class="my-0 text-danger"><i class="mdi mdi-block-helper mr-3"></i>CASHARADA</h5>
            </div>
            <div class="card-body">
                <h5 class="card-title mt-0">CASHAR CUSUB</h5>
                <p class="card-text">

                </p>
            </div>
        </div>
        </a>
    </div>

</div>

<div class="row">
    <div class="col-lg-4">
        <a href="/sheekh/new">
            <div class="card border border-primary">
            <div class="card-header bg-transparent border-primary">
                <h5 class="my-0 text-primary"><i class="mdi mdi-bullseye-arrow mr-3"></i>SHEEKHS</h5>
            </div>
            <div class="card-body">
                <a href="/sheekh/new"><h5 class="card-title mt-0">SHEEKH CUSUB</h5></a>
                <p class="card-text">

                </p>
            </div>
        </div>
        </a>
    </div>
    <div class="col-lg-4">
        <a href="/books/new">
            <div class="card border border-success">
            <div class="card-header bg-transparent border-success">
                <h5 class="my-0 text-success"><i class="mdi mdi-check-all mr-3"></i>BUUGAAGTA</h5>
            </div>
            <div class="card-body">
                <h5 class="card-title mt-0">BUUG CUSUB</h5>
                <p class="card-text">

                </p>
            </div>
        </div>
        </a>
    </div>

    <div class="col-lg-4">
        <a href="/casharada/list">
            <div class="card border border-danger">
            <div class="card-header bg-transparent border-danger">
                <h5 class="my-0 text-danger"><i class="mdi mdi-block-helper mr-3"></i>CASHARADA</h5>
            </div>
            <div class="card-body">
                <h5 class="card-title mt-0">LIISKA CASHARADA</h5>
                <p class="card-text">

                </p>
            </div>
        </div>
        </a>
    </div>

</div>

@endsection


@section('pageTitle')
Welcome
@endsection

@section('parentPage')
Home
@endsection
