@extends('layouts.main_layout')

@section('pageTitle')
New Trend
@endsection

@section('parentPage')
Trends
@endsection

@section('content')


@endsection


@section('scripts')
<script>
    window.token = "{{Auth::user()->api_token}}"
</script>
    <script src="/js/trends.js"></script>
@endsection