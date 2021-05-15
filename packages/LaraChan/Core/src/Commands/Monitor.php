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
    protected $signature = 'larachan:monitor {--threads=5} {--replies=5}';

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

            $threads = $this->option('threads');
            $replies = $this->option('replies');

            $headers = ['UUID', 'B', 'R', 'title'];

            

            $threads = Thread::with(['latestReplies' => function($query) use ($replies) {
                    $query->take($replies);
                }])
                ->select('id', 'board', 'reply_count', 'title', 'body')
                ->orderByRaw('
                    LOG10( ABS( reply_count ) + 1 ) * 
                    SIGN( reply_count ) + 
                    ( UNIX_TIMESTAMP( created_at ) /300000 ) DESC
                ')
                ->take($threads)
                ->get()
                ->toArray();

            if (count($threads) > 0) {
                foreach ($threads as $thread) {
                    
                    $image = " ";
                    if ($thread['image']) {
                        $image = ".".pathinfo($thread['image'])['extension']." ";
                    }

                    $this->line(sprintf("/%s %s%s (Replies: %d)", $thread['board'], $thread['id'], $image, $thread['reply_count']));
                    $this->info($thread['title']);
                    $this->line($thread['body']);

                    
                    foreach ($thread['latest_replies'] as $reply) {
                        $image = " ";
                        if ($reply['image']) {
                            $image = ".".pathinfo($reply['image'])['extension']." ";
                        }

                        $this->line("└─ ". $reply['id'] .' - '. $image . $reply['comment']);
                    }
                    $this->line("");
                }
            }


            $this->output->progressStart(30);
            for ($i = 0; $i < 30; $i++) {
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
