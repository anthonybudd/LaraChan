<?php

namespace LaraChan\Core\Models;

use LaraChan\Core\Exceptions\BoardNotFoundException;
use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'board',
        'title',
        'about',
    ];

    public static function findByBoard($board)
    {
        $board = Self::where('board', $board)->get()->first();
        if (!$board) throw new BoardNotFoundException;
        return $board;
    }


    public function threads()
    {
        return $this->hasMany(Thread::class, 'board', 'board')
            ->orderBy('created_at', 'ASC');
    }

}
