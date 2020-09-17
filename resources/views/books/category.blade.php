@extends('layouts.main_layout')

@section('pageTitle')
Buug Cusub
@endsection

@section('parentPage')
Buug
@endsection

@section('content')
<div class="row">
    <div class="col-md-8 col-lg-8">
        <div class="card">
            <div class="card-header">
                List of categories
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Category name</th>
                            <th>Category parent</th>
                            <th>Books</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                            <tr>
                                <td></td>
                                <td>
                                    {{$category->category_name}}
                                </td>
                                <td>
                                    @if ($category->parent_category > 0)
                                        {{$category->Parent->category_name}}
                                    @else
                                        None
                                    @endif
                                </td>
                                <td>
                                    0
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
    <div class="col-md-4 col-lg-4">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">New category</h4>
                <p class="card-title-desc">
                    Diiwaan galinta category cusub
                </p>
                @if (Session::has('success'))

                <div class="alert alert-success"> {{Session::get('success')}} </div>
                
                @elseif($errors->any())
                <div class="alert alert-danger">{{$errors->first()}}</div>
                @endif

                <form action="" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="" class="label">Parent category</label>
                        <select name="parent_category" id="" class="form-control">
                            <option value="-1">Select parent category</option>
                            @foreach ($categories as $category)
                            <option value="{{$category->id}}">
                                {{$category->category_name}}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="" class="label">Category name</label>
                        <input type="text" class="form-control" name="category_name" 
                        placeholder="Enter category name">
                    </div>
                    <button type="submit" class="btn btn-primary">
                        Add category
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
