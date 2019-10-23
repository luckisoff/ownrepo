<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Faker\Generator as Faker;
use DB;

class Test extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kbc:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Save dummy data to tests table';

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
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(Faker $faker)
    {
      // $this->info(public_path('files/test.txt'));
      /* DB::table('tests')->insert([
        'name' => $faker->name,
        'description' => $faker->paragraph,
        'created_at' => now(),
        'updated_at' => now(),
      ]); */
      echo $faker->paragraph . "\n";
    }
}
