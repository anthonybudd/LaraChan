<?php

namespace LaraChan\Core\Commands;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use LaraChan\Core\Models\Thread;
use LaraChan\Core\Models\Board;
use LaraChan\Core\Models\Reply;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Faker\Factory;


class DeleteBoard extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'larachan:delete-board {boardName}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete a board';

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
        $board = $this->argument('boardName');

        if ($this->confirm("Are you sure you want to delete /$board?")) {
            Reply::where('board', $board)->delete();
            Thread::where('board', $board)->delete();
            Board::where('name', $board)->delete();
        }

        Cache::forget('boards');

        $this->info("Board /$board deleted");
    }
}
