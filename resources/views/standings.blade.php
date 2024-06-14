@extends('app')

@section('title', ' | Tabuľka')

@section('content')

<h2>Tabuľka</h2>

<table>
    <tr>
        <th>Por.</th>
        <th>Meno</th>
        <th>Body</th>
    </tr>

@foreach ($users as $user)
    <tr class="standing position{{$loop->index + 1}}">
        <td>{{ $loop->index + 1 }}.</td>
        <td>
            <a href="{{ route('user', $user->id) }}">
                {{ $user->name }}
            </a>
        </td>
        <td>{{ $user->points }}</td>
    </tr>
@endforeach

</table>

@endsection