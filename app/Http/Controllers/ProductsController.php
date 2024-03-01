<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
class ProductsController extends Controller
{
    public function index()
    {
        //
    }
    public function create()
    {
        //
    }
    public function store(Request $request)
    {
        //
    }

        /**
        * @OA\Get(
        *      path="api/products/{product}",
        *      summary="List Product",
        *      description="show List Product",
        *      @OA\Response(
        *          response=201,
        *          description="Register Successfully",
        *          @OA\JsonContent()
        *       ),
        *      @OA\Parameter(
        *      in="path",
        *      name="product",
        *      required=true,
        *      @OA\Schema(type="$v2")
        *       ),
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
        
    public function show(string $id)
    {
        //
    }

        /**
        * @OA\Get(
        *      path="api/products/{product}/edit",
        *      summary="List Product",
        *      description="edit List Product",
        *      @OA\Response(
        *          response=201,
        *          description="Register Successfully",
        *          @OA\JsonContent()
        *       ),
        *      @OA\Parameter(
        *      in="path",
        *      name="product",
        *      required=true,
        *      @OA\Schema(type="$v2")
        *       ),
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
        
    public function edit(string $id)
    {
        //
    }

        /**
        * @OA\Put(
        *      path="api/products/{product}",
        *      summary="Update Product",
        *      description="update Update Product",
        *      @OA\Response(
        *          response=201,
        *          description="Register Successfully",
        *          @OA\JsonContent()
        *       ),
        *      @OA\Parameter(
        *      in="path",
        *      name="product",
        *      required=true,
        *      @OA\Schema(type="$v2")
        *       ),
        *     required={"id","name","description","price","stock","created_at","updated_at"},
        *       @OA\Property(property="id", type="integer"),
        *       @OA\Property(property="name", type="string"),
        *       @OA\Property(property="description", type="text"),
        *       @OA\Property(property="price", type="number"),
        *       @OA\Property(property="stock", type="integer"),
        *       @OA\Property(property="created_at", type="string"),
        *       @OA\Property(property="updated_at", type="string"),

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
        
    public function update(Request $request, string $id)
    {
        //
    }

        /**
        * @OA\Delete(
        *      path="api/products/{product}",
        *      summary="Delete Product",
        *      description="destroy Delete Product",
        *      @OA\Response(
        *          response=201,
        *          description="Register Successfully",
        *          @OA\JsonContent()
        *       ),
        *      @OA\Parameter(
        *      in="path",
        *      name="id",
        *      required=true,
        *      @OA\Schema(type="integer")
        *       ),
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
        
    public function destroy(string $id)
    {
        //
    }

        /**
        * @OA\Get(
        *      path="api/altro/{id}/{name}",
        *      summary="List Product",
        *      description="myMethod List Product",
        *      @OA\Response(
        *          response=201,
        *          description="Register Successfully",
        *          @OA\JsonContent()
        *       ),
        *      @OA\Parameter(
        *      in="path",
        *      name="id",
        *      required=true,
        *      @OA\Schema(type="$v2")
        *       ),
        *      @OA\Parameter(
        *      in="path",
        *      name="name",
        *      required=true,
        *      @OA\Schema(type="$v2")
        *       ),
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
        
    public function myMethod(){
    }

        /**
        * @OA\Post(
        *      path="api/add/product/{id}/{price}",
        *      summary="Product",
        *      description="myMethod2 Product",
        *      @OA\Response(
        *          response=201,
        *          description="Register Successfully",
        *          @OA\JsonContent()
        *       ),
        *      @OA\Parameter(
        *      in="path",
        *      name="id",
        *      required=true,
        *      @OA\Schema(type="$v2")
        *       ),
        *      @OA\Parameter(
        *      in="path",
        *      name="price",
        *      required=true,
        *      @OA\Schema(type="$v2")
        *       ),
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
        
    public function myMethod2(){
    }
}