<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Str;
use App\Jobs\ProductCreated;
use App\Jobs\ProductUpdated;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Events\ProductUpdatedEvent;
use App\Jobs\ProductDeleted;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    public function index()
    {
        return Product::all();
    }

    public function store(Request $request)
    {
        $product = Product::create($request->only('title', 'description', 'image', 'price'));

        // clone same product to checkout service
        ProductCreated::dispatch($product->toArray())->onQueue('checkout_topic');
        ProductCreated::dispatch($product->toArray())->onQueue('ambassador_topic');
  

        return response($product, Response::HTTP_CREATED);
    }

    public function show(Product $product)
    {
        return $product;
    }

    public function update(Request $request, Product $product)
    {
        $product->update($request->only('title', 'description', 'image', 'price'));

        ProductUpdated::dispatch($product->toArray())->onQueue('checkout_topic');
        ProductUpdated::dispatch($product->toArray())->onQueue('ambassador_topic');


        return response($product, Response::HTTP_ACCEPTED);
    }

    public function destroy(Product $product)
    {
        $product->delete();

        ProductDeleted::dispatch(['id'=> $product->id])->onQueue('checkout_topic');
        ProductDeleted::dispatch(['id'=> $product->id])->onQueue('ambassador_topic');


        return response(null, Response::HTTP_NO_CONTENT);
    }

   
}
