<?php namespace App\Http\Controllers;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductCollection;
use App\Models\Product;
use Illuminate\Http\Request;

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
    public function update(UpdateProductRequest $request, string $id,Product $product)
    {
        $product->update($request->validated());
        return response()->json($product);
    }

    public function destroy(string $id)
    {
        $product = Product::where('id',$id)->deleted();
        return response()->json($product);
    }


    public function myMethod2(Request $request,$parameters){
    }


}
