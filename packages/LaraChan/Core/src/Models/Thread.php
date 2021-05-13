<?php

namespace LaraChan\Core\Models;

use Illuminate\Database\Eloquent\Model;
use LaraChan\Core\Traits\Uuids;
use LaraChan\Core\Traits\Image;

class Thread extends Model
{
    use Uuids, Image;
    
    /**s
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'board',
        'title',
        'image',
        'body',
    ];


    public function board()
    {
        return $this->belongsTo(Board::class, 'board');
    }

    public function replies()
    {
        return $this->hasMany(Reply::class, 'thread', 'id')
            ->orderBy('created_at', 'ASC');
    }
    
    public function latestReplies()
    {
        return $this->hasMany(Reply::class, 'thread', 'id')
            ->orderBy('created_at', 'DESC')
            ->take(3);
    }
}
