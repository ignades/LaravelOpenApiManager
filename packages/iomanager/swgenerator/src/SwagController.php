<?php namespace Iomanager\Swgenerator;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Routing\RouteCompiler;
use Symfony\Component\Routing\Route as RouteSymfony;
use Illuminate\Support\Str;


class SwagController extends Controller {

    public array $jayParsedAry=array();
    public ?string $metodo_cercato = null;

    public ?string $property = null;

    public string $url;

    public array $annotation = [];

    public array $methods = [];
    public array $crud_methods = [];

    public string $crud_method ;

    public ?string $method = null;
    public ?string $model = null;

    public ?string $controller = null;
    public array $routeParameters=[];
    public array $extraParameters=[];


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
            $compiledRoute[$k] = RouteCompiler::compile(new RouteSymfony($this->url));

            $this->routeParameters = $compiledRoute[$k]->getVariables();
            $this->extraParameters = $compiledRoute[$k]->getTokens();

            $this->metodo_cercato = strpbrk($v->action["uses"], '@');

            $metodo[$k] = str_replace("@", '',$this->metodo_cercato);

            $find_controller = explode("\\", $v->action["uses"]);

            //Controller
            $this->controller = str_replace($this->metodo_cercato, '', $find_controller[3]);

            //model
            $this->model = str_replace("sController", '', $this->controller);

            //Define swagger
            $swagger_annotations[$this->controller]='';

            //CRUD Methods
            $this->crud_methods[$k] = strtolower($v->methods()[0]);

            $this->crud_method = strtolower($v->methods()[0]);

            $this->method = $metodo[$k];

            $this->methods[$metodo[$k]]["crudo"] = $this->crud_methods[$k];

            $this->jayParsedAry["openapi"] = $this->apiVersion();

            $this->jayParsedAry["info"] = $this->createInfo();

            $this->jayParsedAry["servers"] = $this->serverInfo();


            //CRUD index GET
            if($this->method === "index"){

                $this->url = $v->uri();
                $componentName = $this->crud_methods[$k]."$this->model";
                $this->jayParsedAry["paths"]["/$this->url"][$this->crud_methods[$k]] = $this->createPath($componentName);
                $this->jayParsedAry["components"]["schemas"][$componentName] = $this->createComponentResponseModel();

            };

            //CRUD store POST ******************************************************************
            if($this->method === "store"){
                $componentName = $this->crud_methods[$k]."$this->model";
                $this->url = $v->uri();
                $this->jayParsedAry["paths"]["/$this->url"][$this->crud_methods[$k]] = $this->createPathPost($componentName);
                $this->jayParsedAry["components"]["schemas"][$componentName] = $this->createComponentResponseModel();

            }

            //***Not necessary this return blade view with input parameters
            //if($this->method === "create"){
            //}

            //CRUD update PUT/PATCH ******************************************************************
            if($this->method === "update"){

                if(count($this->routeParameters)>0){
                    $this->jayParsedAry["paths"]["/$this->url"][$this->crud_methods[$k]]["parameters"]=$this->getColumnModel($this->model);
                }

                $componentName = $this->crud_methods[$k]."$this->model";
                $this->url = $v->uri();
                $this->jayParsedAry["paths"]["/$this->url"][$this->crud_methods[$k]] = $this->createPathPost($componentName);
                $this->jayParsedAry["components"]["schemas"][$componentName] = $this->createComponentResponseModel();

            }

            //CRUD show PUT/PATCH ******************************************************************
            if($this->method === "show"){

                $componentName = $this->crud_methods[$k]."$this->model"."ById";
                $this->url = $v->uri();
                $this->jayParsedAry["paths"]["/$this->url"][$this->crud_methods[$k]] = $this->createPathPost($componentName);
                $this->jayParsedAry["components"]["schemas"][$componentName] = $this->createComponentResponseModel();

            }
            //CRUD edit POST {id}
            if($this->method === "edit"){
                if(count($this->routeParameters)>0){
                    $this->jayParsedAry["paths"]["/$this->url"][$this->crud_methods[$k]]["parameters"]=$this->getColumnModel($this->model);
                }

                $componentName = $this->crud_methods[$k]."$this->model"."Edit";
                $this->url = $v->uri();
                $this->jayParsedAry["paths"]["/$this->url"][$this->crud_methods[$k]] = $this->createPathPost($componentName);
                $this->jayParsedAry["components"]["schemas"][$componentName] = $this->createComponentResponseModel();

            }
            //CRUD DELETE  {id} ******************************************************************
            if($this->method === "destroy"){
                if(count($this->routeParameters)>0){
                    $this->jayParsedAry["paths"]["/$this->url"][$this->crud_methods[$k]]["parameters"]=$this->getColumnModel($this->model);
                }

                $componentName = $this->crud_methods[$k]."$this->model";
                $this->url = $v->uri();
                $this->jayParsedAry["paths"]["/$this->url"][$this->crud_methods[$k]] = $this->createPathPost($componentName);
                $this->jayParsedAry["components"]["schemas"][$componentName] = $this->createComponentResponseModel();

            }
            // Others personal Methods
            if($this->method !== "index" &&  $this->method !== "create" && $this->method !== "store" && $this->method !== "show" && $this->method !== "edit" && $this->method !== "update" && $this->method !== "destroy")
            {
                $componentName = $this->crud_methods[$k].str_replace("@","",$this->metodo_cercato);
                $this->url = $v->uri();
                $this->jayParsedAry["paths"]["/$this->url"][$this->crud_methods[$k]] = $this->createPathExtraPost($componentName);
                //Intercept extra parameters
                if(count($this->routeParameters)>0){

                    $this->jayParsedAry["paths"]["/$this->url"][$this->crud_methods[$k]]["parameters"] = $this->checkParameters($this->model,$this->routeParameters);

                }
                $this->jayParsedAry["components"]["schemas"][$componentName]["type"]="object";
                $allParameters[]=$this->componentExtraParameters($this->model,$this->routeParameters);
                foreach ($allParameters as $kk =>$parameter){
                    $this->jayParsedAry["components"]["schemas"][$componentName]["properties"]=$parameter;
                }

            }

        }
        //dd($allParameters);

        $content =  json_encode($this->jayParsedAry, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);//JSON_PRETTY_PRINT

        $file = '../../storage/api-docs.json';
        Storage::disk('storage')->put("api-docs.json", $content);

        return $this->jayParsedAry;
    }


    public function apiVersion():string {

        return "3.0.0";

    }

    public function createInfo() {

        $jayParsedAry["title"] ="IoManager for Swagger";
        $jayParsedAry["description"] = "Producer of Api Documentation";
        $jayParsedAry["version"] = "1.0.1";
        return $jayParsedAry;
    }

    public function serverInfo() {

        $jayParsedAry[]["url"]="http://localhost:8000/";

        return $jayParsedAry;
    }

    public function createPath($componentName){

        $jayParsedAry["description"] = "LIST $this->model method ";

        $jayParsedAry["responses"]["200"]["description"] = "Successfully response!";

        $jayParsedAry["responses"]["200"]["content"]["application/json"]["schema"]['$ref'] = '#/components/schemas/'.$componentName;


        //$jayParsedAry["/api/register"]["post"]["requestBody"]['$ref'] = "#/components/schemas/Article";
        //$jayParsedAry["/api/register"]["post"]["responses"] = $this->createResponsesJoson();

        return $jayParsedAry;
    }

    public function createPathPost($componentName){

        $jayParsedAry["tags"][] = $componentName;

        $jayParsedAry["summary"] = "$this->model method $componentName";

        $jayParsedAry["operationId"] = "$componentName";

        if($this->method === "show"){

            $jayParsedAry["parameters"][] = $this->getSingleColumnModel($this->model,"id");

        }
        elseif($this->method === "edit"){
            $jayParsedAry["parameters"][] = $this->getSingleColumnModel($this->model,"id");
        }
        elseif($this->method === "destroy"){
            $jayParsedAry["parameters"][] = $this->getSingleColumnModel($this->model,"id");
        }
        else{
            $jayParsedAry["parameters"] = $this->getColumnModel($this->model);
        }

        $jayParsedAry["responses"]["200"]["description"] = "Successfully response!";

        $jayParsedAry["responses"]["401"]["description"] = "Unauthenticated";

        $jayParsedAry["responses"]["400"]["description"] = "Bad Request";

        $jayParsedAry["responses"]["404"]["description"] = "nor found";

        $jayParsedAry["responses"]["403"]["description"] = "Forbidden";

        $jayParsedAry["responses"]["419"]["description"] = "Page Expired required Token";

        $jayParsedAry["responses"]["200"]["content"]["application/json"]["schema"]['$ref'] = '#/components/schemas/'.$componentName;

        return $jayParsedAry;
    }

    public function createPathExtraPost($componentName){

        //$jayParsedAry["tags"] = "$componentName";

        $jayParsedAry["summary"] = "$this->model method $componentName";

        $jayParsedAry["operationId"] = "$componentName";

        $jayParsedAry["parameters"] = $this->componentExtraParameters($this->model,$this->routeParameters);

        $jayParsedAry["responses"]["200"]["description"] = "Successfully response!";

        $jayParsedAry["responses"]["401"]["description"] = "Unauthenticated";

        $jayParsedAry["responses"]["400"]["description"] = "Bad Request";

        $jayParsedAry["responses"]["404"]["description"] = "nor found";

        $jayParsedAry["responses"]["403"]["description"] = "Forbidden";

        $jayParsedAry["responses"]["419"]["description"] = "Page Expired required Token";

        $jayParsedAry["responses"]["200"]["content"]["application/json"]["schema"]['$ref'] = '#/components/schemas/'.$componentName;

        return $jayParsedAry;
    }

    public function createComponentResponseModel(){

        $jayParsedAry["type"] ="object";

        $jayParsedAry["properties"]  = $this->getItemsJson($this->model);

        return $jayParsedAry;
    }

    public function checkParameters($model,$parameters){
        $m = 'App\Models\\'.$model;
        $model = new $m();
        $table = $model->getTable();
        $columns = Schema::getColumnListing($table);
        //dd($columns);
        $array_parameters = array();
        //dd($parameters);
        foreach ($parameters as $k => $parameter){
            //if is exatra parameter not present in model add this to
            $i=1;
            if(array_search($parameter, $columns)===false){

                $strig=$this->extraParameters[0][1];
                $clean = str_replace("?","",$strig);
                $clean = str_replace("&","",$clean);
                $params = explode('type=',$clean);

                unset($params[0]);
                if($k==0){
                    $vvalore[$k]=$k+1;
                    $type[$k] = $params[$vvalore[$k]];
                }else{
                    $type[$k] = $params[$k];
                }

                $array_parameters[$k]["name"] = $parameter;
                $array_parameters[$k]["required"] = true;
                $array_parameters[$k]["in"] = "path";
                $array_parameters[$k]["description"] = "Properties $table";
                $array_parameters[$k]["schema"]["type"] =$type[$k];
            }
            if(array_search($parameter, $columns)!==false){

                $type_column = Schema::getColumnType($table, $parameter);
                $array_parameters[$k]["name"] = $parameter;
                $array_parameters[$k]["required"] = true;
                $array_parameters[$k]["in"] = "path";
                $array_parameters[$k]["description"] = "Properties $table";
                $array_parameters[$k]["schema"]["type"] = $this->mapDataType($type_column);
            }


        }

        return $array_parameters;
    }

    public function componentExtraParameters($model,$parameters)
    {
        $m = 'App\Models\\' . $model;
        $model = new $m();
        $table = $model->getTable();
        $columns = Schema::getColumnListing($table);
        //dd($columns);
        $array_parameters = array();
        //dd($parameters);
        foreach ($parameters as $k => $parameter) {
            //if is exatra parameter not present in model add this to
            $i = 1;
            if (array_search($parameter, $columns) === false) {

                $strig = $this->extraParameters[0][1];
                $clean = str_replace("?", "", $strig);
                $clean = str_replace("&", "", $clean);
                $params = explode('type=', $clean);

                unset($params[0]);
                if ($k == 0) {
                    $vvalore[$k] = $k + 1;
                    $type[$k] = $params[$vvalore[$k]];
                } else {
                    $type[$k] = $params[$k];
                }

                $array_parameters[$parameter]["type"] = $type[$k];
            }
            if (array_search($parameter, $columns) !== false) {

                $type_column = Schema::getColumnType($table, $parameter);
                $array_parameters[$parameter]["type"] = $this->mapDataType($type_column);
            }

        }

        return $array_parameters;
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
            $parameters[$k]["required"] = true;
            $parameters[$k]["in"] = "path";
            $parameters[$k]["description"] = "Properties $table";
            $parameters[$k]["schema"]["type"] = $this->mapDataType($type_column);;
        }

        return $parameters;
    }

    public function getSingleColumnModel($model,$column):array{

        $m = 'App\Models\\'.$model;
        $model = new $m();
        $table = $model->getTable();
        $columns = Schema::getColumnListing($table);
        //Definition of Required Parameters in Body to update Product
        $parameters = array();

        $type_column = Schema::getColumnType($table, $column);
        $parameters["name"] = $column;
        $parameters["required"] = true;
        $parameters["in"] = "path";
        $parameters["description"] = "Properties $table";
        $parameters["schema"]["type"] = $this->mapDataType($type_column);;

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
            //$parameters[$column_name]["required"] = true;
            $parameters[$column_name]["type"] = $this->mapDataType($type_column);

        }
        return $parameters;
    }

    public function getColumnType($parameter,$model):string
    {
        $m = 'App\Models\\'.$model;
        $model = new $m();
        $table = $model->getTable();

        $column = Schema::getColumnType($table,$parameter);
        switch ($column) {
            case "bigint":
            case "int":
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
            case "bigint":
            case "int":
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
