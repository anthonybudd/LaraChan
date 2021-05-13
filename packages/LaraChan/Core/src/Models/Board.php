<?php

namespace LaraChan\Core\Models;

use LaraChan\Core\Exceptions\BoardNotFoundException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Board extends Model
{
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'title',
        'about',
    ];

    protected static function booted()
    {
        static::created(function ($board) {
            Cache::forget('boards');
        });
    }
        

    public static function findByBoard($name)
    {
        $board = Self::where('name', $name)->get()->first();
        if (!$board) throw new BoardNotFoundException;
        return $board;
    }


    public function threads()
    {
        return $this->hasMany(Thread::class, 'board', 'name')
            ->orderBy('created_at', 'ASC');
    }

    public function getPopularThreads($page)
    {
        return Thread::where('board', $this->name)
            ->orderByRaw('
                LOG10( ABS( reply_count ) + 1 ) * 
                SIGN( reply_count ) + 
                ( UNIX_TIMESTAMP( created_at ) /300000 ) DESC
            ')
            ->skip(10 * $page)
            ->take(10)
            ->get();
    }

}
