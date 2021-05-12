<?php

namespace LaraChan\Core\Http;

use Illuminate\Routing\Controller as BaseController;
use LaraChan\Core\Models\Board;
use View;

class LaraChanBaseController extends BaseController
{
    public function __construct()
    {
        $boards = Board::all(); // cached

        View::share('boards', $boards);
    }  
}
