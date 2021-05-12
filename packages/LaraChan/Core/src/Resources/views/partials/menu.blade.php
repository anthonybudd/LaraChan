<div class="col-md-12 px-2 mt-1">
    [
    <a class="text-white subtle" href="/">home</a> 
    @foreach($boards as $board)
     / <a class="text-white subtle" href="/{{ $board->board }}">{{ $board->board }}</a>
    @endforeach
    ]
</div>