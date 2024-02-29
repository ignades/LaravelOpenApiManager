<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\SwaggerController;
use Illuminate\Support\Facades\Artisan;

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
