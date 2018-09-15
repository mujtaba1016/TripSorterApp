<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SortTrip extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'SortTrip {id=0}{format=0}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
    public function handle()
    {
        $id = $this->argument('id');
        // $format = $transport_type = $this->choice('Please select the Format type?', ['web', 'cli']);
        $format = $this->argument('format');
        if ($format == 'cli' or $format == 0) {
            
            if ($id == 0) {
            echo "Enter the Id with command";
            }else{
                    $list = json_decode(file_get_contents('http://127.0.0.1:8000/api/sort_api/'.$id.'/cli'), true);
                    foreach ($list['List'] as $key) {
                    $this->info("\n".$key."\n");
                    }
                }

        }elseif ($format == 'web') {
            
        if ($id == 0) {
            echo "Enter the Id with command";
        }else{
            $list = json_decode(file_get_contents('http://127.0.0.1:8000/api/sort_api/'.$id.'/'.$format), true);
            foreach ($list['List'] as $key) {
                $this->info("\n".$key."\n");
            }
        }
         
        }
    }
}
