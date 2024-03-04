<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\SwaggerController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Process;

class CreateSwagl5 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-swagl5';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command create the Annotations Open Api 3.0 on all Controllers from API routes';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //Add git changes
        $id = rand(5, 250000);
        Process::run('git add .');
        Process::run('git commit -m "Open Api doc version '.$id.'"');
        $swag = new SwaggerController;
        $res = $swag->generateAnnotations();
        if ($res==="OK"){
            $this->info('Annotation created successful!');
            //REGENERATE JSON
            Artisan::call('l5-swagger:generate');
        }else{
            $this->info('Annotation NOT created!');
        }
    }
}
