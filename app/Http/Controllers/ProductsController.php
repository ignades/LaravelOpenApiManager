<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
class ProductsController extends Controller
{

                                        /**
                                        * @OA\Get(
                                        *      path="api/prods/id",
                                        *      summary="",
                                        *      tags={"index Product"},
                                        *      description="",
                                        *      @OA\Response(
                                        *          response=200,
                                        *          description="successful operation"
                                        *       )
                                        *     )
                                        */

    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

                                        /**
                                        * @OA\Post(
                                        *      path="api/prods/id",
                                        *      summary="",
                                        *      tags={"store Product"},
                                        *      description="",
                                        *      @OA\Response(
                                        *          response=200,
                                        *          description="successful operation"
                                        *       )
                                        *     )
                                        */

    public function store(Request $request)
    {
        //
    }

                                        /**
                                        * @OA\Get(
                                        *      path="api/prods/id/{id}",
                                        *      summary="List Product",
                                        *      tags={"show Product"},
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
                                        *      summary="List Product",
                                        *      tags={"edit Product"},
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

    public function edit(string $id)
    {
        //
    }

                                    /**
                                    * @OA\Put(
                                    *      path="api/prods/id/{id}",
                                    *      summary="Update Product",
                                    *      tags={"update Product"},
                                    *      description="Update Product",
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
                                    *       )
                                    *     @OA\RequestBody(
                                    *         @OA\JsonContent(),
                                    *         @OA\MediaType(
                                    *            mediaType="multipart/form-data",
                                    *            @OA\Schema(
                                    *               type="object",
                                    *     required={"id","name","description","price","stock","created_at","updated_at"},
                                    *       @OA\Property(property="id", type="integer"),
                                    *       @OA\Property(property="name", type="string"),
                                    *       @OA\Property(property="description", type="text"),
                                    *       @OA\Property(property="price", type="number"),
                                    *       @OA\Property(property="stock", type="integer"),
                                    *       @OA\Property(property="created_at", type="string"),
                                    *       @OA\Property(property="updated_at", type="string"),

                                    *            ),
                                    *        ),
                                    *    ),
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
                                        *      path="api/prods/id/{id}",
                                        *      summary="Delete Product",
                                        *      tags={"destroy Product"},
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
                                        *      tags={"myMethod Product"},
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

                                        /**
                                        * @OA\Post(
                                        *      path="api/add/product/{id}/{price}",
                                        *      summary="Product",
                                        *      tags={"myMethod2 Product"},
                                        *      description="Product",
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
                                        *      name="price",
                                        *      required=true,
                                        *      @OA\Schema(type="string")
                                        *       )
                                        *     )
                                        */

    public function myMethod2(){
    }
}
