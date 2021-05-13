<div class="container mt-4">
    <div class="col-md-12 ">
    
        <nav>
            <ul class="pagination justify-content-center">
                @if($page > 1)
                    <li class="page-item"><a class="page-link" href="{{ request()->path() }}?page={{($page-1)}}">Previous</a></li>
                @endif

                @if($page !== 1)
                    <li class="page-item"><a class="page-link" href="{{ request()->path() }}?page=1">1</a></li>
                    @if($page > 5)
                        <li class="page-item"><a class="page-link" href="{{ request()->path() }}?page=1">...</a></li>
                    @endif
                @endif

                @for ($i = 3; $i > 0; $i--)
                    @if(($page - $i) > 1)
                    <li class="page-item"><a class="page-link" href="{{ request()->path() }}?page={{($page-$i)}}">{{($page-$i)}}</a></li>
                    @endif
                @endfor

                <li class="page-item active"><a class="page-link active" href="{{ request()->path() }}?page={{($page)}}">{{$page}}</a></li>

                @for ($i = 1; $i < 3; $i++)
                    <li class="page-item"><a class="page-link" href="{{ request()->path() }}?page={{($page+$i)}}">{{($page+$i)}}</a></li>
                @endfor

                <li class="page-item"><a class="page-link" href="{{ request()->path() }}?page={{($page+1)}}">Next</a></li>
            </ul>
        </nav>
    </div>
</div>