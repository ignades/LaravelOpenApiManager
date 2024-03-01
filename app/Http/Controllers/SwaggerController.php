<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\Routing\RouteCompiler;
use App\Models\Product;
use Symfony\Component\Routing\Route as RouteSymfony;
use Illuminate\Support\Str;

class SwaggerController extends Controller
{

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

            //echo $metodo[$k]."<br>";
            $find_controller = explode("\\", $v->action["uses"]);

            //Controller
            $this->controller = str_replace($metodo_cercato, '', $find_controller[3]);

            //model
            $this->model = str_replace("sController", '', $this->controller);

            //Define swagger
            $swagger_annotations[$this->controller]='';

            //CRUD Methods
            $this->crud_method[$k] = ucfirst(strtolower($v->methods()[0]));

            $this->method = $metodo[$k];
            $this->methods[$metodo[$k]]["params"] =  $compiledRoute->getVariables();
            $this->methods[$metodo[$k]]["crudo"] = $this->crud_method[$k];

            //CRUD index GET
            if($this->method === "index"){

                $stringa = $this->indexAnnotation($this->url,$this->model);

                $this->swagger_annotations[$k]=$stringa;
            }

            //CRUD store POST ******************************************************************
//            if($this->method === "store"){
//                if(count($this->methods[$metodo[$k]]["params"]) > 0){
//                    //create annotation swagger parameters
//                    //echo "crea Url parameter if exist";
//                    foreach($this->methods[$metodo[$k]]["params"] as $v2){
//                        $this->parametro = '
//        *      @OA\Parameter(
//        *      in="path",
//        *      name="' . $v2 . '",
//        *      required=true,
//        *      @OA\Schema(type="$v2")
//        *       ),';
//                    }
//                }
//
//                //END Annotation
//                $data = $this->startAnnotation($this->method,$this->crud_method[$k], $this->model,$this->url). $this->parametro . $this->RequestBody($this->model) . $this->endAnnotation();
//
//                $this->swagger_annotations[$k]=$data;
//                $this->array_swagger[$this->controller][$this->method][$k] = $this->swagger_annotations[$k];
//            }


            //CRUD update PUT/PATCH ******************************************************************
            if($this->method === "update"){

                if(count($this->methods[$metodo[$k]]["params"]) > 0){
                    //create annotation swagger parameters
                    //echo "crea Url parameter if exist";
                    foreach($this->methods[$metodo[$k]]["params"] as $v2){
                        $this->parametro = '
        *      @OA\Parameter(
        *      in="path",
        *      name="' . $v2 . '",
        *      required=true,
        *      @OA\Schema(type="$v2")
        *       ),';
                    }
                }

                //END Annotation
                $data = $this->startAnnotation($this->method,$this->crud_method[$k], $this->model,$this->url). $this->parametro . $this->RequestBody($this->model) . $this->endAnnotation();

                $this->swagger_annotations[$k]=$data;
                $this->array_swagger[$this->controller][$this->method][$k] = $this->swagger_annotations[$k];
            }


            //CRUD show PUT/PATCH ******************************************************************
            if($this->method === "show"){

                //Start Annotation
                if(count($this->methods[$metodo[$k]]["params"]) > 0){
                    //create annotation swagger parameters
                    //echo "crea Url parameter if exist";
                    foreach($this->methods[$metodo[$k]]["params"] as $v2){
                        $this->parametro = '
        *      @OA\Parameter(
        *      in="path",
        *      name="' . $v2 . '",
        *      required=true,
        *      @OA\Schema(type="$v2")
        *       ),';

                    }
                }
                //END Annotation
                $data = $this->startAnnotation($this->method,$this->crud_method[$k], $this->model,$this->url). $this->parametro . $this->endAnnotation();

                $this->swagger_annotations[$k]=$data;
                $this->array_swagger[$this->controller][$this->method][$k] = $this->swagger_annotations[$k];
            }
            //CRUD edit POST {id}
            if($this->method === "edit"){
                //Start Annotation
                if(count($this->methods[$metodo[$k]]["params"]) > 0){
                    //create annotation swagger parameters
                    //echo "crea Url parameter if exist";
                    foreach($this->methods[$metodo[$k]]["params"] as $v2){
                        $this->parametro = '
        *      @OA\Parameter(
        *      in="path",
        *      name="' . $v2 . '",
        *      required=true,
        *      @OA\Schema(type="$v2")
        *       ),';
                    }
                }
                //END Annotation
                $data = $this->startAnnotation($this->method,$this->crud_method[$k], $this->model,$this->url). $this->parametro . $this->endAnnotation();

                $this->swagger_annotations[$k]=$data;
                $this->array_swagger[$this->controller][$this->method][$k] = $this->swagger_annotations[$k];
            }
            //CRUD DELETE  {id} ******************************************************************
            if($this->method === "destroy"){

                if(count($this->methods[$this->method]["params"]) > 0){
                    //create annotation swagger parameters
                    $parametro='';
                    //echo "crea Url parameter if exist";
                    foreach($this->methods[$this->method]["params"] as $v2){
                        if($this->method !== strtolower($this->model)){
                            $v2='id';
                            $this->ParameterType = $this->getColumnType($v2,$this->model);
                            $parametro .= '
        *      @OA\Parameter(
        *      in="path",
        *      name="'.$v2.'",
        *      required=true,
        *      @OA\Schema(type="' . $this->ParameterType . '")
        *       ),';
                        }else{
                            $this->ParameterType = $this->getColumnType($v2,$this->model);
                            $parametro .= '
        *      @OA\Parameter(
        *      in="path",
        *      name="'.$v2.'",
        *      required=true,
        *      @OA\Schema(type="' . $this->ParameterType . '")
        *       ),';
                        }

                    }
                }
                //END Annotation
                $data = $this->startAnnotation($this->method,$this->crud_method[$k], $this->model,$this->url). $parametro . $this->endAnnotation();

                $this->swagger_annotations[$k]=$data;
                $this->array_swagger[$this->controller][$this->method][$k] = $this->swagger_annotations[$k];
            }
            // Others personal Methods
            if($this->method !== "index" &&  $this->method !== "create" && $this->method !== "store" && $this->method !== "show" && $this->method !== "edit" && $this->method !== "update" && $this->method !== "destroy")
            {
                //Start Annotation
                if(count($this->methods[$this->method]["params"]) > 0){
                    //create annotation swagger parameters
                    $parametro='';
                    //echo "crea Url parameter if exist";
                    foreach($this->methods[$this->method]["params"] as $v2){
                        if($this->method !== strtolower($this->model))
                            $parametro .= '
        *      @OA\Parameter(
        *      in="path",
        *      name="' . $v2 . '",
        *      required=true,
        *      @OA\Schema(type="$v2")
        *       ),';

                    }
                    //END Annotation
                    $data = $this->startAnnotation($this->method,$this->crud_method[$k], $this->model,$this->url). $parametro . $this->endAnnotation();

                    $this->swagger_annotations[$k]=$data;
                }
                $this->array_swagger[$this->controller][$this->method][$k] = $this->swagger_annotations[$k];
            }

         }





//        $patternx = "/$this->controller/";
//        if (preg_match($patternx, $v->action["uses"]) == true){
//            $this->array_swagger[$this->controller][$this->method] = $this->swagger_annotations;
//        }

        //write
        //dd($this->array_swagger);
        //echo json_encode($this->array_swagger);

        $this->write_controllers($this->array_swagger);

        return "OK";
    }


     public function indexAnnotation($url,$model):string {
         $stringa = '
        /**
        * @OA\Get(
        *      path="'.$url.'",
        *      summary="List '.$model.'",
        *      tags={"show '.$model.'"},
        *      description="List '.$model.'",
        *      @OA\Response(
        *          response=200,
        *          description="successful operation"
        *       ),
        *      @OA\Response(
        *          response=200,
        *          description="Register Successfully",
        *          @OA\JsonContent()
        *       ),
        *      @OA\Response(
        *          response=404,
        *          description="Result Not Found",
        *          @OA\JsonContent()
        *       ),
        *      @OA\Response(response=400, description="Bad request"),
        *      @OA\Response(response=404, description="Resource Not Found"),
        * )
        */
        */';
         return $stringa;
     }

    public function startAnnotation($method,$crud_method, $model,$url_api):string{

        $this->MethodDescription = $this->methodDescription($crud_method, $model);
        $start = '
        /**
        * @OA\\'.$crud_method.'(
        *      path="'.$url_api.'",
        *      summary="'.$this->MethodDescription.'",
        *      description="'.$method.' ' .$this->MethodDescription.'",
        *      @OA\Response(
        *          response=201,
        *          description="Register Successfully",
        *          @OA\JsonContent()
        *       ),';
        return $start;
    }

    public function endAnnotation():string
    {
        $end='
        *      @OA\Response(
        *          response=201,
        *          description="Register Successfully",
        *          @OA\JsonContent()
        *       ),
        *      @OA\Response(
        *          response=200,
        *          description="Register Successfully",
        *          @OA\JsonContent()
        *       ),
        *      @OA\Response(
        *          response=422,
        *          description="Unprocessable Entity",
        *          @OA\JsonContent()
        *       ),
        *      @OA\Response(response=400, description="Bad request"),
        *      @OA\Response(response=404, description="Resource Not Found"),
        * )
        */
        ';
        return $end;
    }

    public function urlParameter():string {

        //$column_type = $this->getColumnType($this->parametro,$model);
        $column_type = gettype($this->property);
        $this->parametro .= '
        *      @OA\Parameter(
        *      in="path",
        *      name="' . $this->property . '",
        *      required=true,
        *      @OA\Schema(type="'.$column_type.'")
        *       ),';
        return $this->parametro;
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
           case "bigint":
               $type_column =  "integer";
               break;
           case "varchar":
               $type_column =  "string";
               break;
           case "text":
               $type_column =  "text";
               break;
           case "decimal":
               $type_column =  "number";
               break;
           case "int":
               $type_column =  "integer";
               break;
           case "timestamp":
               $type_column =  "string";
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

    public function RequestBody($model){
        $m = 'App\Models\\'.$model;
        $model = new $m();
        $table = $model->getTable();
        $columns = Schema::getColumnListing($table);
        //var_dump($columns);
        //Definition of Required Parameters in Body to update Product
        $required='';
        $properties='';
        $body='';
        $num_cols = count($columns);
        $nline='';
        $i=0;
        foreach($columns as $k=>$column_name){

             $type_column = Schema::getColumnType($table,$column_name);
             $col_type =  $this->mapDataType($type_column);
             $required .=  '"'.$column_name.'",';
             if ($i<$num_cols){
                 $nline="\n";
             }
$properties .= '
        *       @OA\Property(property="'.$column_name.'", type="'.$col_type.'"),'.$nline;
        $i++;
        }
$body .= "
        *     required={".substr($required , 0, -1)."},"."\n";
        $body .=$properties;

        $body = preg_replace('/\n\s*\n/', "\n", $body);

        return $body;

    }

    public function mapDataType($column):string {

        //Mapping Integration Server Data Types to Swagger Data Types
        switch ($column) {
            case "bigint":
                $type_column =  "integer";
                break;
            case "varchar":
                $type_column =  "string";
                break;
            case "text":
                $type_column =  "text";
                break;
            case "decimal":
                $type_column =  "number";
                break;
            case "int":
                $type_column =  "integer";
                break;
            case "timestamp":
                $type_column =  "string";
                break;
        }
        return $type_column;

   }



}
