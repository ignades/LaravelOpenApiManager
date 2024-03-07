<?php namespace App\Http\Controllers;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductCollection;
use App\Models\Product;
use Illuminate\Http\Request;
use Throwable;

class ProductsController extends Controller
{
    public function index()
    {
        $products = Product::paginate();
        return (new ProductCollection($products))->response();
    }
    public function create()
    {
        return view('products.create');
    }

    public function store(StoreProductRequest $request)
    {

         $product =  Product::create($request->validated());
         return response()->json($product);
    }

    public function show(string $id)
    {
        $product = Product::where('id',$id)->first();
        return response()->json($product);
    }

    public function edit(string $id)
    {
        //
    }
    public function update(UpdateProductRequest $request, string $id)
    {
        try {
            $product = Product:: where('id', $id)->first();
            $product->update($request->validated());
        }catch (\Exception $exception) {
            return response()->json([
                'errors' => $exception->getMessage()
            ], 500);
        }


        return response()->json( ["status"=>200,"product"=>$product],201);
    }

    public function destroy(string $id)
    {
        try {
            $product = Product::destroy($id);

        }catch (Throwable $exception){

            return response()->json(['error' => $exception->getMessage()],404);
        }
        if($product==0)
            return response()->json(['error' => "Product Not Found"],404);

        return response()->json(['success' => true],201);

    }


    public function myMethod2(string $stock){

        $product = Product::where('stock',$stock)->get();
        if(count($product)==0)
            return response()->json(['error' => "Product Not Found"],404);

        return response()->json(['success' => $product],201);
    }


}
