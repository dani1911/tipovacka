@extends('layouts._base')

@section('content')

<div class="w-full h-full flex flex-col items-center justify-center gap-4 text-center p-4">
    <h3 class="title-h3">404 | {{ __('Page not found') }}</h3>
    <p>{{ __('The page you are looking for does not exist.') }}</p>
</div>

@endsection