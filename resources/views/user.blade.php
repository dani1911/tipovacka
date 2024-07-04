@extends('app')

@section('title', ' | ' . $user->name)

@section('content')

@include('_partials.stage.nav')

<div class="content flex flex-column flex-align-i-center refresh-data">

    @include('_partials.user.stats')

</div>

@endsection