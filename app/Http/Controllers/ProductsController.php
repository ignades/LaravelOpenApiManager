<?php namespace App\Http\Controllers;
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


    public function myMethod2(Request $request,$parameters){
    }

    public function register()
    {

    }
}
