<?php

namespace App\Http\Controllers;

use App\Http\Requests\Products\StoreProductRequest;
use App\Http\Requests\Products\UpdateProductRequest;
use App\Line;
use App\Permission;
use App\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $this->authorize('view', Product::class);

        if ($request->wantsJson()) {
            $products = Product::all();

            return response()->json($products);
        }


        return view("products.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $this->authorize('create', Product::class);

        $lines = Line::select('id', 'name')->get();
        $permissions = Permission::select('id', 'label')->get();

        return view("products.create", compact("lines", "permissions"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request) {
        $newProduct = Product::create([
            'name'          => $request->get("name"),
            'content'       => $request->get("content"),
            'keywords'      => $request->get("keywords"),
            'permission_id' => $request->get("permission_id"),
        ]);

        $newProduct->lines()->sync($request->get("line_id"));

        return redirect()->route('products.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product) {
        $this->authorize('edit', Product::class);

        $lines = Line::select('id', 'name')->get();
        $permissions = Permission::select('id', 'label')->get();

        return view('products.edit',
            compact('product', 'lines', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Product             $product
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, Product $product) {
        $product->update([
            'name'          => $request->get("name"),
            'content'       => $request->get("content"),
            'keywords'      => $request->get("keywords"),
            'permission_id' => $request->get("permission_id"),
        ]);

        $product->lines()->sync($request->get("line_id"));

        return redirect()->route('products.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product) {
        //
    }
}
