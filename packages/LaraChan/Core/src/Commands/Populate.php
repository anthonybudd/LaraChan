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


class Populate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'larachan:populate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed the database with fake data';

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
        $this->info('Seeding..');
        $faker = Factory::create();

        $boards = [
            'g' => 'General',
            'a' => 'Anime & Manga',
            'v' => 'Video Games',
            't' => 'Technology',
            'w' => 'Weapons',
            'o' => 'Auto',
            's' => 'Sports',
            'sci' => 'Science & Math',
            'his' => 'History & Humanities',
            'out' => 'Outdoors',
            'p' => 'Photography',
            'ck' => 'Food & Cooking',
            'lit' => 'Literature',
            'mu' => 'Music',
            'wg' => 'Wallpapers/General',
            'fa' => 'Fashion',
            'gd' => 'Graphic Design',
            'dit' => 'Do-It-Yourself',
            'biz' => 'Business & Finance',
            'trv' => 'Travel',
            'x' => 'Paranormal',
            'lgbt' => 'LGBT',
            'news' => 'News',
            'r9k' => 'ROBOT9001',
            'pol' => 'Politically Incorrect',
        ];

        foreach ($boards as $board => $title) {
            $this->info("Creating Board /$board");
            Board::create([
                'name' => $board,
                'title' => $title,
                'about' => $faker->sentence(),
            ]);
        }

        $this->info("");
        foreach ($boards as $board => $title) {
            $threads = rand(20, 30);
            $this->info("Generating $threads threads for /$board");
            for ($i = 0; $i < $threads; $i++) {

                $thread = Thread::create([
                    'board' => $board,
                    'title' => $i.' - '.$faker->sentence(),
                    'image' => env('APP_URL').'/storage/larachan/images/code.png',
                    'body' => $faker->paragraph(),
                ]);
                sleep(1);

                $replies = rand(20, 30);
                for ($ii = 0; $ii < $replies; $ii++) {
                    Reply::create([
                        'board' => $board,
                        'thread' => $thread->id,
                        'image' => (rand(1, 3) === 1)? env('APP_URL').'/storage/larachan/images/code.png' : null,
                        'comment' => $faker->sentence(),
                    ]);
                }                
            }
        }   
    }
}
