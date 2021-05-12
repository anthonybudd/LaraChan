<?php

namespace LaraChan\Core\Database\Seeders;

use Illuminate\Database\Seeder;

class LaraChanSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \LaraChan\Core\Models\Board::create([
            'board' => 'r',
            'title' => 'Random',
            'about' => 'A board.',
        ]);

        \LaraChan\Core\Models\Thread::create([
            'id' => 'd828a2c0-f1db-463f-9da2-f9d07eb2fea5',
            'board' => 'r',
            'title' => 'Welcome to LaraChan',
            'image' => env('APP_URL').'/storage/images/code.png',
            'body' => 'Welcome to LaraChan',
        ]);

        \LaraChan\Core\Models\Reply::create([
            'board' => 'r',
            'thread' => 'd828a2c0-f1db-463f-9da2-f9d07eb2fea5',
            'image' => null,
            'comment' => 'First!!',
        ]);

    }
}
