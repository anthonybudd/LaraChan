@extends('larachan::layouts.root')

@section('content')
<div class="container-fluid p-0">
	<div class="overflow-hidden m-0 bg-primary text-white">

        @include('larachan::partials.menu')

		<div class="col-md-5 p-lg-5 mx-auto my-5 text-center ">
			<h1 class="display-4 fw-normal">{{ $board->title }}</h1>
            <p class="lead">{{ $board->about }}</p>
            <a href="/{{ $board->board }}/new-thread" class="btn btn-light btn-lg mt-4"">Start A Thread</a>
		</div>
	</div>

    <div class="row justify-content-center m-0">
        @foreach($threads as $thread)
		<div class="col-md-8 mt-4">
            <div class="container-fluid py-4 bg-primary-light">
                <div class="row">
                    <div class="col-md-12">
                        <p class="mb-0">
                            Anonymous: <span class="fw-bold">{{ $thread->title }}</span>
                            {{ $thread->created_at }}
                        </p>
                        <p>
                            <a href="{{ $thread->image }}">
                                {{ $thread->filename() }}
                            </a>
                        </p>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-4">
                        <a href="{{ $thread->image }}">
                            <img src="{{ $thread->image }}" class="w-100" />
                        </a>
                    </div>
                    <div class="col-md-8">
                        <p>{{ $thread->body }}</p>
                    </div>
                </div>

                
                <div class="row mt-4">

                    @if(count($thread->replies) !== 0)
                    <div class="col-md-12 mb-2">
                        {{ count($thread->replies) }} replies. <a href="/{{$board->board}}/{{$thread->id}}/">Click here</a> to view.
                    </div>
                    @endif


                    @foreach($thread->replies as $reply)
                        @include('larachan::partials.reply', ['reply' => $reply])
                    @endforeach

                    <div class="col-md-12">
                        <a href="/{{$board->board}}/{{$thread->id}}#reply">Reply</a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    
    <div class="container mt-4">
        <div class="col-md-12 ">
            <nav>
                <ul class="pagination justify-content-center">
                    <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item"><a class="page-link" href="#">Next</a></li>
                </ul>
            </nav>
        </div>
    </div>

</div>
@stop