<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Iomanager\Swgenerator\SwagController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Process;
use L5Swagger\Http\Controllers\SwaggerController;
use function Laravel\Prompts\info;

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

        $swag = new SwagController;
        $res = $swag->generateAnnotations();
        if ($res==="OK"){
            //Add git changes
            $id = rand(5, 250000);
            shell_exec('git add .');
            shell_exec('git commit -m "Open Api doc version '.$id.'"');
            $this->info('The json file was generated!');
        }else{
            $this->info('JSON NOT created!') ;
        }

    }
}
