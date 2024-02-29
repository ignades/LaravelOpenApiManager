<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *     description="This is an example API for users management",
 *     version="1.0.0",
 *     title="User Management API"
 * )
 */

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
