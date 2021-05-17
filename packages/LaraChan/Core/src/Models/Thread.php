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
        'id',
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

    public function url()
    {
        return sprintf("%s/%s/%s", env('LARACHAN_ONION_ADDRESS', env('APP_URL')), $this->board, $this->id);
    }
}
