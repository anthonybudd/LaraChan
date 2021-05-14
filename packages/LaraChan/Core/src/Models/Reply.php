<?php

namespace LaraChan\Core\Models;

use Illuminate\Database\Eloquent\Model;
use LaraChan\Core\Traits\Uuids;
use LaraChan\Core\Traits\Image;

class Reply extends Model
{
    use Uuids, Image;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'thread',
        'board',
        'image',
        'comment',
    ];

    protected static function booted()
    {
        static::created(function ($reply) {
            // Inefficent, use DB query.
            $reply->thread()->increment('reply_count');
        });
    }

    public function thread()
    {
        return $this->belongsTo(Thread::class, 'thread');
    }

}
