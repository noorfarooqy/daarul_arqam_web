@extends('layouts.main_layout')

@section('pageTitle')
Muxaadarooyinka List
@endsection

@section('parentPage')
Muxaadarooyin
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 col-lg-12">

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">list of Muxaadarooyin</h4>
                        <p class="card-title-desc">
                            List Muxaadarooyin
                        </p>

                        <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Cinwaanka</th>
                                    <th>Goobta</th>
                                    <th>Muxaadarada</th>
                                    <th>File size</th>
                                    <th>Date</th>
                                </tr>
                            </thead>


                            <tbody>
                                @foreach ($muxaadarooyinka as $muxaadaro)
                                <tr>
                                    <td>
                                        {{$muxaadaro->sermon_title}}
                                    </td>
                                    <td>{{$muxaadaro->sermon_location}}</td>
                                    <td>
                                        <audio controls>
                                            <source src="{{$muxaadaro->sermon_file_url}}" type="audio/mpeg">
                                            Your browser does not support the audio element.
                                        </audio>
                                    </td>
                                    <td>{{round($muxaadaro->sermon_file_size/1000000, 2)}} MB</td>
                                    <td>{{$muxaadaro->updated_at->format('y-m-d')}}</td>
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
