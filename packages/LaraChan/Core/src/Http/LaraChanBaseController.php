<?php

namespace LaraChan\Core\Http;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Cache;
use LaraChan\Core\Models\Board;
use Illuminate\Http\Request;
use View;

class LaraChanBaseController extends BaseController
{
    public function __construct(Request $request)
    {
        
        $boards = Cache::get('boards');
        if (!$boards) {
            $boards = Board::all();
            Cache::put('boards', $boards);
        }
        View::share('boards', $boards);

        View::share('page', $request->query('page', 1));
    }  
}
