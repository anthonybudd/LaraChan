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


class CreateBoard extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'larachan:create-board {boardName} {boardTitle} {about?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new board';

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
        $board = Board::create([
            'name' => $this->argument('boardName'),
            'title' => $this->argument('boardTitle'),
            'about' => $this->argument('about') ?? '',
        ]);

        $this->info("Created new board /$board->name");
    }
}
