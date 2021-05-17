@extends('larachan::layouts.root')

@section('content')
<div class="container-fluid p-0">
	<div class="overflow-hidden m-0 pb-2 bg-primary text-white">
        @include('larachan::partials.menu')
        
        <div class="col-md-6 p-lg-5 mx-auto my-5 text-center ">
			<p class="lead">{{ $thread->title }}</p>
		</div>
	</div>

    <div class="row justify-content-center m-0">
		<div class="col-md-8 mt-4">
            <div class="container-fluid py-4 bg-primary-light">
                <div class="row">
                    <div class="col-md-12">
                        <p class="mb-0 font-10">
                            {{ $thread->url() }}
                        </p>
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
                    @foreach($thread->replies as $reply)
                        @include('larachan::partials.reply', ['reply' => $reply])
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div id="reply" class="row justify-content-center m-0">
        <div class="col-md-8 my-4">
            <hr class="my-4">
            <form method="POST" enctype="multipart/form-data" action="/{{$thread->board}}/{{$thread->id}}">
                
                <input type="hidden" name="key" value="{{ $key }}">
                <input type="hidden" name="board" value="{{ $thread->board }}">
                <input type="hidden" name="thread" value="{{ $thread->id }}">

                <div class="row g-3">
                    <div class="col-md-12">
                        <label for="comment" class="form-label">Comment</label>                        
                        @if($formErrors !== false && $formErrors['errors']->has('comment'))
                            <textarea class="form-control" id="comment" name="comment" rows="3" required="">{{ $formErrors['data']->comment }}</textarea>
                            <div class="invalid-feedback d-block">{{ $formErrors['errors']->first('comment') }}</div>
                        @elseif($formErrors !== false)
                            <textarea class="form-control" id="comment" name="comment" rows="3" required="">{{ $formErrors['data']->comment }}</textarea>
                        @else
                            <textarea class="form-control" id="comment" name="comment" rows="3" required=""></textarea>
                        @endif
                    </div>
                </div>
                <div class="row g-3 mt-2">
                    <div class="col-md-12">
                        <div class="input-group mb-3">
                            <input type="file" class="form-control" id="image" name="image" aria-label="Upload">
                            @if($formErrors !== false && $formErrors['errors']->has('image'))
                                <div class="invalid-feedback d-block">{{ $formErrors['errors']->first('image') }}</div>
                            @endif
                        </div>
                    </div>
                </div>
                 <div class="row g-3">
                    <div class="col-md-12">
                        <label for="comment" class="form-label">Captcha</label>
                        <img src="{{ $captcha }}" class="d-block mb-2" width="200" />
                        <input type="text" class="form-control mb-2" id="title" name="captcha"  placeholder="" value="" required="">
                        @if($formErrors !== false && $formErrors['errors']->has('captcha'))
                            <div class="invalid-feedback d-block">Invalid CAPTCHA</div>
                        @endif
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-md-12 text-right">
                        <button class="btn btn-primary text-white" type="submit">Reply</button> 
                    </div>
                </div>
            </form>
        </div>
    </div>
    
</div>
@stop