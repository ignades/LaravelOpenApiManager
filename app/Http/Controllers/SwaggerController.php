<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Routing\RouteCompiler;
use App\Models\Product;
use Symfony\Component\Routing\Route as RouteSymfony;
use Illuminate\Support\Str;

class SwaggerController extends Controller
{
    public array $jayParsedAry=array();
    public ?string $ParameterType = null;
    public ?string $MethodDescription = null;
    public ?string $parametro = null;
    public ?string $property = null;
    public string $url;
    public array $annotation = [];
    public array $methods = [];
    public array $crud_methods = [];
    public array $swagger_annotations = [];
    public ?string $method = null;
    public ?string $model = null;
    public ?string $controller = null;
    public array $array_swagger=[];


    public function generateAnnotations()
    {
        $routeCollection = collect(Route::getRoutes())->filter(function ($route) {
            return Str::startsWith($route->action['prefix'], 'api');
        });

        //dd($routeCollection);

        //define array swaggers for each controller
        $array_swagger = array();

        foreach ($routeCollection as $k => $v)
        {

            $this->url = $v->uri();

            //Getting Parameters compiled
            $compiledRoute = RouteCompiler::compile(new RouteSymfony($this->url));

            $metodo_cercato = strpbrk($v->action["uses"], '@');

            $metodo[$k] = str_replace("@", '', $metodo_cercato);

            $find_controller = explode("\\", $v->action["uses"]);

            //Controller
            $this->controller = str_replace($metodo_cercato, '', $find_controller[3]);

            //model
            $this->model = str_replace("sController", '', $this->controller);

            //Define swagger
            $swagger_annotations[$this->controller]='';

            //CRUD Methods
            $this->crud_method[$k] = strtolower($v->methods()[0]);

            $this->method = $metodo[$k];

            $this->methods[$metodo[$k]]["crudo"] = $this->crud_method[$k];

            $this->jayParsedAry["openapi"] = $this->apiVersion();

            $this->jayParsedAry["info"] = $this->createInfo();

            $this->jayParsedAry["servers"] = $this->serverInfo();


            //CRUD index GET
            if($this->method === "index"){

                $this->url = $v->uri();

                $this->jayParsedAry["paths"] = $this->createPath($this->url,$this->crud_method[$k]);
                $this->jayParsedAry["components"] = $this->createComponentResponseModel();

             };

            //CRUD store POST ******************************************************************
//            if($this->method === "store"){
//                //echo $metodo[$k];
//                $this->url = $v->uri();
//                $this->jayParsedAry["paths"][] = $this->createPath($this->url,$this->crud_method[$k]);
//                //$this->jayParsedAry["paths"] =$this->createParameters($this->url,$this->crud_method[$k]);
//            }
//
//            if($this->method === "create"){
//                //echo $metodo[$k];
//                $this->url = $v->uri();
//                $this->jayParsedAry["paths"][] = $this->createPath($this->url,$this->crud_method[$k]);
//
//            }


            //echo json_encode($this->jayParsedAry);

            //CRUD update PUT/PATCH ******************************************************************
            if($this->method === "update"){

            }

            //CRUD show PUT/PATCH ******************************************************************
            if($this->method === "show"){

            }
            //CRUD edit POST {id}
            if($this->method === "edit"){

            }
            //CRUD DELETE  {id} ******************************************************************
            if($this->method === "destroy"){

            }
            // Others personal Methods
            if($this->method !== "index" &&  $this->method !== "create" && $this->method !== "store" && $this->method !== "show" && $this->method !== "edit" && $this->method !== "update" && $this->method !== "destroy")
            {

            }

         }

        //return $this->jayParsedAry;

        $content =  json_encode($this->jayParsedAry, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);//JSON_PRETTY_PRINT

        $file = '../../storage/api-docs.json';
        Storage::disk('storage')->put("api-docs.json", $content);

        exit;
        //file_put_contents($file, $content);


        return "OK";
    }


    public function apiVersion():string {

        return "3.0.0";

    }

    public function createInfo() {

        $jayParsedAry["title"] ="User Management API";
        $jayParsedAry["description"] = "This is an example API for users management";
        $jayParsedAry["version"] = "1.0.0";
        return $jayParsedAry;
    }

    public function serverInfo() {

        $jayParsedAry[]["url"]="http://localhost:8000/";

        return $jayParsedAry;
    }
    /*
     *         "/url": {
            "get": {
                "description": "New endpoint",
                "responses": {
                    "200": {
                        "description": "New response",
                        "content": {
                            "application/json": {
                                "schema": {
                                    "": ""
                                }
                            }
                        }
                    }
                }
            }
        }
    }*/
    public function createPath($apiUrl,$crud_method){

        $jayParsedAry["/$apiUrl"]["$crud_method"]["description"] = "LIST $this->model method $crud_method";

        $jayParsedAry["/$apiUrl"]["$crud_method"]["responses"]["200"]["description"] = "Successfully response!";

        $jayParsedAry["/$apiUrl"]["$crud_method"]["responses"]["200"]["content"]["application/json"]["schema"]['$ref'] = '#/components/schemas/getProducts';



        //$jayParsedAry["/api/register"]["post"]["requestBody"]['$ref'] = "#/components/schemas/Article";
        //$jayParsedAry["/api/register"]["post"]["responses"] = $this->createResponsesJoson();

        return $jayParsedAry;
    }

    //Json Output parameters index method
    public function createJsonWaited (){


        $jayParsedAry["200"] = ["description"=>"Successful response"];

        $jayParsedAry["content"]["application/json"]["schema"]["type"]="array";

        $jayParsedAry["content"]["application/json"]["schema"]["items"]["type"]="object";

        $jayParsedAry["content"]["application/json"]["schema"]["items"]["required"] = $this->getItemsJson($this->model);

        return $jayParsedAry;
    }


    public function createComponentResponseModel(){

        $jayParsedAry["schemas"]["getProducts"]["type"] ="object";

        $jayParsedAry["schemas"]["getProducts"]["properties"]  = $this->getItemsJson($this->model);

        return $jayParsedAry;
    }


    public function createParameters($apiUrl,$crud_method){

        $jayParsedAry["$apiUrl"]["$crud_method"]["parameters"][] = $this->getColumnModel($this->model);

        return $jayParsedAry;
    }

    public function getColumnModel($model):array{

        $m = 'App\Models\\'.$model;
        $model = new $m();
        $table = $model->getTable();
        $columns = Schema::getColumnListing($table);

        //Definition of Required Parameters in Body to update Product

        $parameters = array();

        foreach($columns as $k=>$column_name) {
            $type_column = Schema::getColumnType($table, $column_name);
            $parameters[$k]["name"] = $column_name;
            $parameters[$k]["in"] = "path";
            $parameters[$k]["description"] = "Properties $table";
            $parameters[$k]["schema"]["type"] = $this->mapDataType($type_column);;
        }

        return $parameters;

    }

    public function getItemsJson($model):array{

        $m = 'App\Models\\'.$model;
        $model = new $m();
        $table = $model->getTable();
        $columns = Schema::getColumnListing($table);

        //Json response of parameters

        $parameters = array();

        foreach($columns as $k=>$column_name) {

            $type_column = Schema::getColumnType($table, $column_name);

            $parameters[$column_name]["type"] = $this->mapDataType($type_column);

        }

        return $parameters;

    }





    public function extra_methods($method,$crud_method,$model,$url):string{
        $stringa = '';
        //Start Annotation
        $stringa .= $this->startAnnotation($method,$crud_method, $model,$url);

        if(count($this->methods[$method]["params"]) > 0){
            //create annotation swagger parameters
            //echo "crea Url parameter if exist";
            foreach($this->methods[$method]["params"] as $v2){
                $this->property = $v2;
                $stringa .= $this->urlParameter($this->model);
            }
        }
        //END Annotation
        $stringa .= $this->endAnnotation();
        return $stringa;
    }

   public function write_controllers($array_swagger){

       foreach ($array_swagger as $k =>$v){

           //Create new file with annotations $k = controller
           $filename = dirname(__FILE__).'/'.$k.'.php';

           if(!file_exists($filename)){
               //create file
               $f = fopen($filename, 'wb');
               if (!$f) {
                   die('Error creating the file ' . $filename);
               }
               fclose($f);
           }

           //copy original on new cleaning comments

           $current = file_get_contents("$k.php", true);
           $data = preg_replace('!/\*.*?\*/!s', '', $current);
           $data = preg_replace('/\n\s*\n/', "\n", $data);
           file_put_contents($filename, $data);

           foreach ($v as $k2=>$annotation){
               //metodo $k2;

               $search      = "$k2";
               $line_number = false;

               if ($handle = fopen(dirname(__FILE__).'/'.$k.'.php', "r")) {
                   $count = 0;
                   while (($line = fgets($handle, 4096)) !== FALSE and !$line_number) {
                       $count++;
                       $line_number = (strpos($line, $search) !== FALSE) ? $count : $line_number;
                   }
                   fclose($handle);
               }

               //write here on $line_number

               $filepathname = dirname(__FILE__).'/'.$k.'.php';

               $stats = file(dirname(__FILE__).'/'.$k.'.php', FILE_IGNORE_NEW_LINES);
               $offset = $line_number;
               $valore = $array_swagger[$k][$k2];
               array_splice($stats, $offset-1, 0, $valore);
               file_put_contents($filepathname, join("\n", $stats));

           }
       }

   }

   public function getColumnType($parameter,$model):string
   {
       $m = 'App\Models\\'.$model;
       $model = new $m();
       $table = $model->getTable();

       $column = Schema::getColumnType($table,$parameter);
       switch ($column) {
           case "int":
           case "bigint":
               $type_column =  "integer";
               break;
           case "text":
           case "timestamp":
           case "date":
           case "date-time":
           case "password":
           case "varchar":
               $type_column =  "string";
               break;
           case "decimal":
               $type_column =  "number";
               break;
           case "boolean":
               $type_column =  "boolean";
               break;
       }
       return $type_column;

   }

    public function methodDescription($method,$model):string
    {
        switch ($method) {
            case "Get":
                $descr = "List $model";
                break;
            case "Put":
                $descr = "Update $model";
                break;
            case "Delete":
                $descr = "Delete $model";
                break;
            case "Edit":
                $descr = "Edit $model";
                break;
            default:
                $descr = "$model";

        }
        return $descr;

    }


    public function mapDataType($column):string {

        //Mapping Integration Server Data Types to Swagger Data Types
        switch ($column) {
            case "int":
            case "bigint":
                $type_column =  "integer";
                break;
            case "text":
            case "timestamp":
            case "varchar":
                $type_column =  "string";
                break;
            case "decimal":
                $type_column =  "number";
                break;
        }
        return $type_column;

   }



}
