<?php namespace App\Http\Controllers;
use App\Http\Resources\ProductCollection;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/users/",
     *     summary="List users",
     *     operationId="list_users",
     *     description="Returns a list of users that are registered on a server with pagination",
     *     @OA\Response(
     *         response=200,
     *         description="List of users",
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Something went wrong",
     *     )
     * )
     */
    public function index()
    {
        $products = Product::paginate();
        return (new ProductCollection($products))->response();
    }
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }
    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }



    public function myMethod(){
    }


    public function myMethod2(){
    }
    /**
     * @OA\Post(
     *     path="/api/register",
     *     summary="Register a new user",
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="User's name",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="email",
     *         in="query",
     *         description="User's email",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="password",
     *         in="query",
     *         description="User's password",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="201", description="User registered successfully"),
     *     @OA\Response(response="422", description="Validation errors")
     * )
     */
    public function register()
    {

    }
}
