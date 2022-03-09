@extends('templates.main')

@section('content')

<div class="w-25">
    <canvas id="myChart"></canvas>
</div>

<script src="{{ $script }}"></script>

@endsection