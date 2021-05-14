<?php

namespace LaraChan\Core\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class Install extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */

    protected $signature = 'larachan:install {--platform=pc}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install LaraChan';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /*
     * Install and configure larachan.
     */
    public function handle()
    {
        // check for .env
        $this->checkForEnvFile();

        // loading values at runtime
        $this->loadEnvConfigAtRuntime();

        // running `php artisan migrate`
        $this->warn('Step: Migrating all tables into database...');
        $migrate = $this->call('migrate:fresh');

        // running `php artisan db:seed --class=LaraChan\\Core\\Database\\Seeders\\LaraChanSeeder`
        $this->warn('Step: Seeding DB');
        $result = $this->call('db:seed', ['--class' => 'LaraChan\Core\Database\Seeders\LaraChanSeeder']); 

        // running `php artisan vendor:publish --all`
        $this->warn('Step: Publishing assets and configurations...');
        $result = $this->call('vendor:publish', ['--provider' => 'LaraChan\Core\Providers\CoreServiceProvider']);

        // running `php artisan storage:link`
        $this->warn('Step: Linking storage directory...');
        $result = $this->call('storage:link');

        // optimizing
        $this->warn('Step: Optimizing...');
        $result = $this->call('optimize');

        // running `composer dump-autoload`
        $this->warn('Step: Composer autoload...');
        $result = shell_exec('composer dump-autoload');

        // final information
        $this->info('-----------------------------');
        $this->info('Congratulations!');
        $this->info('LaraChan installation successful');
    }

    /**
    *  Checking .env file and if not found then create .env file.
    *  Then ask for database name, password & username to set
    *  On .env file so that we can easily migrate to our db.
    */
    protected function checkForEnvFile()
    {
        $envExists = File::exists(base_path() . '/.env');

        if (!$envExists) {
            $this->info('Creating the environment configuration file.');
            $this->createEnvFile();
        } else {
            $this->info('Great! your environment configuration file already exists.');
        }

        $this->call('key:generate');
    }

    /**
     * Create a new .env file.
     */
    protected function createEnvFile()
    {
        try {
            File::copy('.env.example', '.env');

            if ($this->option('platform') === 'pi') {
                $this->envUpdate('DB_HOST=', 'larachan-db');
            }

            $this->envUpdate('DB_DATABASE=', 'larachan');
            $this->envUpdate('DB_DATABASE=', 'larachan');
            $this->envUpdate('DB_USERNAME=', 'app');

        } catch (\Exception $e) {
            $this->error('Error in creating .env file, please create it manually and then run `php artisan migrate` again.');
        }
    }

    /**
     * Load `.env` config at runtime.
     */
    protected function loadEnvConfigAtRuntime()
    {
        $this->warn('Loading configs...');

        /* environment directly checked from `.env` so changing in config won't reflect */
        app()['env'] = $this->getEnvAtRuntime('APP_ENV');

        /* setting for the first time and then `.env` values will be incharged */
        config(['database.connections.mysql.database' => $this->getEnvAtRuntime('DB_DATABASE')]);
        config(['database.connections.mysql.username' => $this->getEnvAtRuntime('DB_USERNAME')]);
        config(['database.connections.mysql.password' => $this->getEnvAtRuntime('DB_PASSWORD')]);
        DB::purge('mysql');

        $this->info('Configuration loaded..');
    }

    /**
     * Check key in `.env` file because it will help to find values at runtime.
     */
    protected static function getEnvAtRuntime($key)
    {
        $path = base_path() . '/.env';
        $data = file($path);

        if ($data) {
            foreach ($data as $line) {
                $line = preg_replace('/\s+/', '', $line);
                $rowValues = explode('=', $line);

                if (strlen($line) !== 0) {
                    if (strpos($key, $rowValues[0]) !== false) {
                        return $rowValues[1];
                    }
                }
            }
        }

        return false;
    }

    /**
     * Update the .env values.
     */
    protected static function envUpdate($key, $value)
    {
        $path = base_path() . '/.env';
        $data = file($path);
        $keyValueData = $changedData = [];

        if ($data) {
            foreach ($data as $line) {
                $line = preg_replace('/\s+/', '', $line);
                $rowValues = explode('=', $line);

                if (strlen($line) !== 0) {
                    $keyValueData[$rowValues[0]] = $rowValues[1];

                    if (strpos($key, $rowValues[0]) !== false) {
                        $keyValueData[$rowValues[0]] = $value;
                    }
                }
            }
        }

        foreach ($keyValueData as $key => $value) {
            $changedData[] = $key . '=' . $value;
        }

        $changedData = implode(PHP_EOL, $changedData);

        file_put_contents($path, $changedData);
    }
}
