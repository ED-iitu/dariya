<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class AudioAnalizer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'utils:audio-info';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get audio file info';

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
     * @return int
     */
    public function handle()
    {
        $file = $this->ask('Укажите файл');
        if(file_exists($file)){
            $this->info("Selected file: {$file}");
            include(base_path("libs/getid3/getid3.php"));
            $getID3 = new \getID3;
            $file = $getID3->analyze($file);
            $playtime_seconds = $file['playtime_seconds'];
            $this->info("Duration: ".gmdate("s", $playtime_seconds));
        }else{
            $this->info("File not found : {$file}");
        }

        return 0;
    }
}
