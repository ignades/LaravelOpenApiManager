<?php

namespace App\Http\Controllers;


use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use App\Http\Controllers\ProductsController;
use ReflectionClass;

class SwaggerController extends Controller
{
   public ? string  $ParameterType = null;
   public function getColumns()
   {
       $routeCollection = Route::getRoutes();
       //dd($routeCollection);

       $pattern = '/api\//';
       //get parameters
       $pattern2 = '/\{/';
       $graffa = '/}/';
       //define array swaggers for each controller
       $array_swagger = array();

       foreach ($routeCollection as $k => $v){

           if (preg_match($pattern, $v->uri()) == true && $k>15) {

               $metodo_cercato =  strpbrk($v->action["uses"], '@');

               $metodo[$k] = str_replace("@",'',$metodo_cercato);

               $find_controller = explode("\\",$v->action["uses"]);
               //Controller
               $controller = str_replace($metodo_cercato,'',$find_controller[3]);
               //Model
               $model = str_replace("sController",'',$controller);


               $parametero='';
               $swagger_annotations=array();
               //$parametero=array();
               if (preg_match($pattern2, $v->uri()) == true) {

                   $count_parameters = explode("{",$v->uri());

                   foreach ($count_parameters as $kk =>$parameter){
                        if (preg_match($graffa, $parameter) == true){

                        $clean_parameter = preg_replace(array("/}/","/\//"), '', $parameter);
                        $this->ParameterType = $this->getColumnType($clean_parameter,$model);
   $parametero.=',
     *      @OA\Parameter(
     *      in="path",
     *      name="'.$clean_parameter.'",
     *      required=true,
     *      @OA\Schema(type="string")
     *       )
    ';
   $swagger_annotations[$k] ='
    /**
     * @OA\\'.ucfirst(strtolower($v->methods()[0])).'(
     *      path="'.$v->uri().'",
     *      summary="Get list of clients",
     *      description="Returns client detail",
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       )'.$parametero.'
     *     )
     *
     */
    ';
                       }
                   }



               }else{
                   $parameter='';
                   $swagger_annotations[$k]='';
               }




               //pushing keys + swagger values
               $patternx = "/$controller/";
               if (preg_match($patternx, $v->action["uses"]) == true){
                   $array_swagger[$controller][$metodo[$k]] = $swagger_annotations[$k];
               }

           }

       }

       $this->write_controllers($array_swagger);

       //$columns = Schema::getColumnListing('users');


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
               $valore = (string)$array_swagger[$k][$k2];
               array_splice($stats, $offset-1, 0, $valore);
               file_put_contents($filepathname, join("\n", $stats));

           }
       }

   }

   public function getColumnType($parameter,$model):string
   {

       return $columns = Schema::getColumnType('users','name');
   }

}
