@extends('larachan::layouts.root')

@section('content')

<div class="container-fluid p-0">
	<div class="overflow-hidden m-0 text-center bg-primary text-white">
		<div class="col-md-5 p-lg-5 mx-auto my-5">
			<h1 class="display-4 fw-normal">{{ $siteName }}</h1>
			<p class="lead">{{ $address }}</p>
		</div>
	</div>

	<div class="row justify-content-center mx-0 mt-4">
		<div class="col-md-8">
			<div class="card mb-4 rounded-3 shadow-sm">
				<div class="card-header py-3">
					<h4 class="my-0 fw-normal">About</h4>
				</div>
				<div class="card-body">
					{{ $about }}
				</div>
			</div>
		</div>
		<div class="col-md-8">
			<div class="card mb-4 rounded-3 shadow-sm">
				<div class="card-header py-3">
					<h4 class="my-0 fw-normal">Boards</h4>
				</div>
				<div class="card-body">
					
                    <div class="row">
						@foreach($boards->chunk(3) as $chunks) 
						<div class="row">
							@foreach($chunks as $board)
							<div class="col-4">
								<ul class="list-unstyled mt-3 mb-4">
									<li>
										<a class="subtle" href="/{{$board->board}}">{{$board->title}}</a>
									</li>
								</ul>
							</div>
							@endforeach
						</div>
						@endforeach
					</div>

				</div>
			</div>
		</div>
	</div>
</div>
@stop