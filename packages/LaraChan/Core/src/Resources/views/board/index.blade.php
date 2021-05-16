@extends('larachan::layouts.root')

@section('content')
<div class="container-fluid p-0">
	<div class="overflow-hidden m-0 bg-primary text-white">

        @include('larachan::partials.menu')

		<div class="col-md-5 p-lg-5 mx-auto my-5 text-center ">
			<h1 class="display-4 fw-normal">{{ $board->title }}</h1>
            <p class="lead">{{ $board->about }}</p>
            <a href="/{{ $board->name }}/new-thread" class="btn btn-light btn-lg mt-4"">Start A Thread</a>
		</div>
	</div>

    <div class="row justify-content-center mx-0 mb-4">

        @if(count($threads) === 0)
        <div class="col-md-8 mt-4">
            <div class="alert alert-dark">
                <p>No threads found</p>

                <a href="/">Home</a>
            </div>
        </div>
        @endif

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
                            <a href="{{ $thread->imageUrl() }}">
                                {{ $thread->filename() }}
                            </a>
                        </p>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-4">
                        <a href="{{ $thread->imageUrl() }}">
                            <img src="{{ $thread->imageUrl() }}" class="w-100" />
                        </a>
                    </div>
                    <div class="col-md-8">
                        <p>{!! nl2br(e($thread->body)) !!}</p>
                    </div>
                </div>

                
                <div class="row mt-4">

                    @if($thread->reply_count > 0)
                    <div class="col-md-12 mb-2">
                        {{ $thread->reply_count }} replies. <a href="/{{$board->name}}/{{$thread->id}}/">Click here</a> to view.
                    </div>
                    @endif

                    @foreach($thread->latestReplies->reverse() as $reply)
                        @include('larachan::partials.reply', ['reply' => $reply])
                    @endforeach

                    <div class="col-md-12">
                        <a href="/{{$board->name}}/{{$thread->id}}#reply">Reply</a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    
    @include('larachan::partials.pagination')
   
</div>
@stop