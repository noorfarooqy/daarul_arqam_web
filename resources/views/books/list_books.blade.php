@extends('layouts.main_layout')

@section('pageTitle')
Buug List
@endsection

@section('parentPage')
Buug
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 col-lg-12">
        
        <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">

                                    <h4 class="card-title">list of books</h4>
                                    <p class="card-title-desc">
                                        List books
                                    </p>

                                    <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>Buuga</th>
                                                <th>Category</th>
                                                <th>Sheekha aqrinayo</th>
                                                <th>Qoraaga buuga</th>
                                                <th>Dhamaadka Casharada</th>
                                                <th>Tirada casharada</th>
                                            </tr>
                                        </thead>

                                        
                                        <tbody>
                                            @foreach ($books as $book)
                                                <tr>
                                                <td>
                                                    <a href="/casharada/new/{{$book->id}}">{{$book->book_name}}</a>
                                                </td>
                                                <td>
                                                    
                                                        @if ($book->Category == null)
                                                            No category
                                                        @else
                                                        <a href="/books/category/{{$book->category}}">
                                                            {{$book->Category->category_name}}
                                                        </a>
                                                        @endif
                                                    
                                                </td>
                                                <td>{{$book->SheekhInfo->sheekh_name}}</td>
                                                <td>{{$book->book_written_by}}</td>
                                                <td>
                                                    @if ($book->book_is_ongoing)
                                                        <i class="fas fa-check-circle" style="color: green; padding-right:5px"></i>Casharada way socdaan
                                                    @else
                                                        <i class="fas fa-times-circle text-green pr-3" style="color:red; padding-right:5px"></i>Casharada waa dhamaad
                                                    @endif
                                                </td>
                                                <td>0</td>
                                            </tr>
                                            @endforeach
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- end col -->
                    </div>

    </div>

</div>

@endsection


@section('scripts')
    <!-- Required datatable js -->
    <script src="/assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
    
    <!-- Buttons examples -->
    <script src="/assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="/assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
    <script src="/assets/libs/jszip/jszip.min.js"></script>
    <script src="/assets/libs/pdfmake/build/pdfmake.min.js"></script>
    <script src="/assets/libs/pdfmake/build/vfs_fonts.js"></script>
    <script src="/assets/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="/assets/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="/assets/libs/datatables.net-buttons/js/buttons.colVis.min.js"></script>
    
    <!-- Responsive examples -->
    <script src="/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="/assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
    <!-- Datatable init js -->
    <script src="/assets/js/pages/datatables.init.js"></script>
@endsection

@section('links')
    
    <!-- DataTables -->
    <link href="/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
@endsection