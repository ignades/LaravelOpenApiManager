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
     *      summary="Get list of clients",
     *      description="Returns client detail",
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *      @OA\Parameter(
     *      in="path",
     *      name="product",
     *      required=true,
     *      @OA\Schema(type="string")
     *       )
    
     *     )
     *
     */
    
    public function show(string $id)
    {
        //
    }
    public function edit(string $id)
    {
        //
    }

    /**
     * @OA\Put(
     *      path="api/products/{product}",
     *      summary="Get list of clients",
     *      description="Returns client detail",
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *      @OA\Parameter(
     *      in="path",
     *      name="product",
     *      required=true,
     *      @OA\Schema(type="string")
     *       )
    
     *     )
     *
     */
    
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * @OA\Delete(
     *      path="api/products/{product}",
     *      summary="Get list of clients",
     *      description="Returns client detail",
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *      @OA\Parameter(
     *      in="path",
     *      name="product",
     *      required=true,
     *      @OA\Schema(type="string")
     *       )
    
     *     )
     *
     */
    
    public function destroy(string $id)
    {
        //
    }

    /**
     * @OA\Get(
     *      path="api/altro/{id}/{project_id}",
     *      summary="Get list of clients",
     *      description="Returns client detail",
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *      @OA\Parameter(
     *      in="path",
     *      name="id",
     *      required=true,
     *      @OA\Schema(type="string")
     *       )
    ,
     *      @OA\Parameter(
     *      in="path",
     *      name="project_id",
     *      required=true,
     *      @OA\Schema(type="string")
     *       )
    
     *     )
     *
     */
    
    public function myMethod(){
    }
}