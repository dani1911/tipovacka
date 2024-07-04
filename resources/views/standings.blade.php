@extends('app')

@section('title', ' | Tabuľka')

@section('content')

<h2>Tabuľka</h2>

@include('_partials.stage.nav')

<div class="box size-xs refresh-data">

    @include('_partials.standings.table')
    
</div>

@endsection