<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Picqer;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::paginate(5);

        return view('products.index', ['products'=> $products]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $product_code = rand(106890122, 100000000);
        $redColor = '255, 0, 0';
        $generate = new Picqer\Barcode\BarcodeGeneratorHTML();
        $barcodes = $generate->getBarCode($product_code, $generate::TYPE_STANDARD_2_5, 2, 60);

        $products = new Product;
        $products->product_name = $request->product_name;
        $products->price = $request->price;
        $products->alert_stock = $request->alert_stock;
        $products->quantity = $request->quantity;
        $products->product_code = $product_code;
        $products->barcode =  $barcodes;
        $products->brand = $request->brand;
        $products->description = $request->description;
        $products->save();

        if($products) {
            return redirect()->back()->with('success','Product Created successfully');
        }
        return redirect()->back()->with('error', 'Product Failed Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $products)
    {
        // $product->update($request->all());
        $product_code = rand(106890122, 100000000);


        $redColor = '255, 0, 0';
        $generate = new Picqer\Barcode\BarcodeGeneratorHTML();
        $barcodes = $generate->getBarCode($product_code, $generate::TYPE_STANDARD_2_5, 2, 60);

        $products = Product::find($products);
        $products->product_name = $request->product_name;
        $products->price = $request->price;
        $products->alert_stock = $request->alert_stock;
        $products->quantity = $request->quantity;
        $products->product_code = $product_code;
        $products->barcode =  $barcodes;
        $products->brand = $request->brand;
        $products->description = $request->description;
        $products->save();

        return redirect()->back()->with('success','Product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->back()->with('success','Product deleted successfully');
    }

    public function GetProductBarcodes()
    {
        $productsBarcode = Product::select('barcode', 'product_code')->get();
        return view('products.barcode.index', compact('productsBarcode'));
    }
}
