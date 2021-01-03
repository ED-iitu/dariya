@foreach($videos as $video)
    <tr data-id="{{ $video->id }}">
        <td>
            <div style="background-image: url({{ $video->image_link }})"></div>
        </td>
        <td>
            {{ $video->name }}
        </td>
    </tr>
@endforeach