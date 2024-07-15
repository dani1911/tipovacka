<table>
    <tr>
        <th>Por.</th>
        <th>Meno</th>
        <th>Body</th>
    </tr>

    @foreach ($users as $user)

    <tr class="standing position{{ $loop->index + 1 }}">
        <td class="rank text-center">{{ $loop->index + 1 }}.</td>
        <td>
            <a href="{{ route('user', $user->id) }}">
                {{ $user->name }}
            </a>
        </td>
        <td class="text-center">{{ $user->points }}</td>
    </tr>

    @endforeach

</table>