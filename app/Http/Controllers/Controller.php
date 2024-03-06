<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
//fix error  Required @OA\PathItem() not found  --->path="http://localhost:8000/docs/api-docs.json"
/**
 * @OA\Info(
 *     description="Producer of Api Documentation",
 *     version="1.0.1",
 *     title="IoManager for Swagger"
 * ),
 * @OA\Get(
 *     path="http://localhost:8000/docs/api-docs.json",
 *     @OA\Response(
 *         response="200",
 *         description="The data"
 *     )
 * )
 */

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
