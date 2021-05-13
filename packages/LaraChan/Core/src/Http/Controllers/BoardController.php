<?php

namespace LaraChan\Core\Http\Controllers;

use Illuminate\Foundation\Validation\ValidatesRequests;
use LaraChan\Core\Exceptions\BoardNotFoundException;
use LaraChan\Core\Http\LaraChanBaseController;
use LaraChan\Core\Models\Board;
use Illuminate\Http\Request;


class BoardController extends LaraChanBaseController
{
    use ValidatesRequests;

    public function index(Request $request, $board)
    {
        try {
            $board = Board::findByBoard($board);
            $page = ($request->query('page'))? intval($request->query('page'))-1 : 0;
            if ($page < 1) $page = 0;

            return view("larachan::board.index", [
                "board" => $board,
                "threads" => $board->getPopularThreads($page),
            ]); 
        } catch (BoardNotFoundException $e) {
            return view("larachan::404"); 
        }      
    }
}
