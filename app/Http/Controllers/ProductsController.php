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
     *      path="api/prods/id/{id}",
     *      summary="List Product",
     *      description="List Product",
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *      @OA\Parameter(
     *      in="path",
     *      name="id",
     *      required=true,
     *      @OA\Schema(type="integer")
     *       )
     *     )
     */
    
    public function show(string $id)
    {
        //
    }

    /**
     * @OA\Get(
     *      path="api/prods/id/{id}/edit",
     *      summary="Edit Product",
     *      description="Edit Product",
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *      @OA\Parameter(
     *      in="path",
     *      name="id",
     *      required=true,
     *      @OA\Schema(type="integer")
     *       )
     *     )
     */
    
    public function edit(string $id)
    {
        //
    }

    /**
     * @OA\Put(
     *      path="api/prods/id/{id}",
     *      summary="Update Product",
     *      description="Update Product",
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *      @OA\Parameter(
     *      in="path",
     *      name="id",
     *      required=true,
     *      @OA\Schema(type="integer")
     *       )
     *     )
     */
    
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * @OA\Delete(
     *      path="api/prods/id/{id}",
     *      summary="Delete Product",
     *      description="Delete Product",
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *      @OA\Parameter(
     *      in="path",
     *      name="id",
     *      required=true,
     *      @OA\Schema(type="integer")
     *       )
     *     )
     */
    
    public function destroy(string $id)
    {
        //
    }

    /**
     * @OA\Get(
     *      path="api/altro/{id}/{name}",
     *      summary="List Product",
     *      description="List Product",
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *      @OA\Parameter(
     *      in="path",
     *      name="id",
     *      required=true,
     *      @OA\Schema(type="integer")
     *       ),
     *      @OA\Parameter(
     *      in="path",
     *      name="name",
     *      required=true,
     *      @OA\Schema(type="string")
     *       )
     *     )
     */
    
    public function myMethod(){
    }
}