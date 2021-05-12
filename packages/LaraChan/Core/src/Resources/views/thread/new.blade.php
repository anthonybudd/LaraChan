@extends('larachan::layouts.root')

@section('content')
<div class="container-fluid p-0">
    <div class="overflow-hidden m-0 bg-primary text-white">
        @include('larachan::partials.menu')
        <div class="col-md-5 p-lg-5 mx-auto my-5 text-center">
            <h1 class="display-4 fw-normal">New Thread</h1>
        </div>
    </div>

    <div class="row justify-content-center mt-4 mx-0">
        <div class="col-md-6">
            <form method="POST" enctype="multipart/form-data" action="/{{ $board->board }}/new-thread">

                <input type="hidden" name="key" value="{{ $key }}">
                <input type="hidden" name="board" value="{{ $board->board }}">
                
                <div class="row g-3">
                    <div class="col-md-12">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" name="title" placeholder="" value="" required="">
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-md-12">
                        <label for="body" class="form-label">Body</label>
                        <textarea class="form-control" id="body" name="body" rows="3" required=""></textarea>
                    </div>
                </div>
                <div class="row g-3 mt-2">
                    <div class="col-md-12">
                        <div class="input-group mb-3">
                            <input type="file" class="form-control" id="image" name="image" aria-label="Upload">
                        </div>
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-md-12">
                        <label for="comment" class="form-label">Captcha</label>
                        <img src="{{ $captcha }}" class="d-block mb-2" width="200" />
                        <input type="text" class="form-control mb-2" id="title" name="captcha"  placeholder="" value="" required="">
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-md-12 text-right">
                        <button class="btn btn-primary text-white" type="submit">New Thread</button> 
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@stop