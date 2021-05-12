<?php

namespace LaraChan\Core\Http\Controllers;

use Illuminate\Foundation\Validation\ValidatesRequests;
use LaraChan\Core\Exceptions\BoardNotFoundException;
use LaraChan\Core\Http\LaraChanBaseController;
use LaraChan\Core\Models\Board;


class BoardController extends LaraChanBaseController
{
    use ValidatesRequests;

    public function index($board)
    {
        try {
            $board = Board::findByBoard($board);
            
            return view("larachan::board.index", [
                "board" => $board,
                "threads" => $board->threads,
            ]); 
        } catch (BoardNotFoundException $e) {
            return view("larachan::404"); 
        }      
    }
}
