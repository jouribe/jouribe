<ul>
    @foreach($posts as $post)
        <li><pre>{{ $post->id }} {{ $post->title }}</pre></li>
    @endforeach
</ul>
