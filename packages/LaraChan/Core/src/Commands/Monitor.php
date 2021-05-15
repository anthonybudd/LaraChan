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


class Monitor extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'larachan:monitor';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Monitor the imageboard live';

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
        while (true) {
            $this->cls();

            $headers = ['UUID', 'B', 'R', 'title'];
            
            $threads = Thread::select('id', 'board', 'reply_count', 'title')
                ->orderByRaw('
                    LOG10( ABS( reply_count ) + 1 ) * 
                    SIGN( reply_count ) + 
                    ( UNIX_TIMESTAMP( created_at ) /300000 ) DESC
                ')
                ->take(15)
                ->get()
                ->toArray();

            $this->table($headers, $threads);
            
            

            $headers = ['UUID', 'Comment'];
            
            $replies = Reply::select('id', 'comment')
                ->orderBy('created_at', 'DESC')
                ->take(15)
                ->get()
                ->toArray();

            $this->table($headers, $replies);





            $this->output->progressStart(60);
            for ($i = 0; $i < 60; $i++) {
                sleep(1);
                $this->output->progressAdvance();
            }
            $this->output->progressFinish();
        }
    }

    public function cls()
    {
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            system('cls');
        } else {
            system('clear');
        }
    }
}
