## Install package in Laravel 
````
composer require iomanager/swgenerator:dev-main
````
## About LaravelOpenApiManager Author:Ignacio Sebastian Olivieri first version  27/02/2024

To do a best Documentation to work on a team I think 27/02/2024 to start create an application to create very fast the annotations on each Controller of laravel to use with Swagger

- [Swagger-OpenAPI Specification](https://swagger.io/docs/specification/about/).

## Requirements

To work with this Package is essential observe rules 

- Use Correct Names of Controllers and Models this code is based on this logic . 
- Example1 Controller ( ProductsController ) Model (Product) OK
- Example2 Controller ( ProdController ) Model (Products) BAD! 
- You can use Resources Routes and Personal Routes of your Controller, Only in : dir routes/api.php OK

`` Mandatory ``
- Step1 Create Controller with methods
- Step2 Create Migration Table 
- Step3 Create Model 
- Step4 Create Routes with methods or Routes::resource or Routes::apiResource 
- Step5 Define Path of OpenApi on class Controller extends BaseController
- 
````
/**
* @OA\Info(
*     description="This is an example API for users management",
*     version="1.0.0",
*     title="User Management API"
* ),
* @OA\Get(
*     path="http://localhost:8000/docs/api-docs.json",
*     @OA\Response(
*         response="200",
*         description="The data"
*     )
* )
*/
class ProductsController extends Controller
{
...
````
## Step 6 Create Artisan Command
````
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
            $this->info('The json file was generated!');
        }else{
            $this->info('JSON NOT created!') ;
        }

    }
}
````
- After the creation of all method in YourController you can run the next command 
- Artisan Commands : to add Annotations on your controller you need use command this will generate the Annotations for each Api Method
````
php artisan app:create-swagl5
````
- Thi documentation and code is under Construction actually work but need more Parameters this will be do from me ;).
- Mandatory : The parameters passed from Url as follow 
- 
- Routes
- Route::post('/product/{id}/{price}', [ProductsController::class,'myMethod']);
- This {id}/{price} parameters are the fields of the DB table so you need write the names equals as reflection of tabel


- Route::post('/product/{id}/{price}', [ProductsController::class,'myMethod']);  OK!
- |--Table 
- |-------- id
- |-------- name
- |-------- price
- |-------- description

- Route::post('/product/{id_prod}/{price_product}', [ProductsController::class,'myMethod']);  BAD!
- |--Table
- |-------- id
- |-------- name
- |-------- price
- |-------- description

## Extra Parameters in personal route
- Example route tha isn't a Resource but a new route with personal parameters this route specify a new method on the Controller of your interes to the first 
- 
- parameter {id_prod} corresponding the first type equal to next parameters .. second=&type=string for example. 
-  
```` 
Route::post('/add/product/{id_prod}/{price}/{extra}?type=integer&type=string', [ProductsController::class,'myMethod2']);
````
## Image Example

![alt text](https://github.com/ignades/IoManager/blob/main/Types.jpg?raw=true)

