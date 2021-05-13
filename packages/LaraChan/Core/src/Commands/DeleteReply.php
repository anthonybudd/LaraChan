<?php

namespace LaraChan\Core\Commands;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use LaraChan\Core\Models\Thread;
use LaraChan\Core\Models\Board;
use LaraChan\Core\Models\Reply;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Faker\Factory;


class DeleteReply extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'larachan:delete-reply {uuid}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete a reply';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Install and configure larachan.
     */
    public function handle()
    {  
        $uuid = $this->argument('uuid');

        if ($this->confirm("Are you sure you want to delete this reply?")) {
            $reply = Reply::find($uuid);

            if ($reply->image) {
                $file = basename($reply->image);
                File::delete(storage_path("app/public/larachan/images/$file"));
                $this->info("Image deleted");
            }

            $reply->delete();            
        }

        $this->info("Reply deleted");
    }
}
