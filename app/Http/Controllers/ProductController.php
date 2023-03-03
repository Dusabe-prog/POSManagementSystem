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

        $product_code = $request->product_code;
        $products = new Product;
        // Image section
        if($request->hasFile('product_image')){
            $files = $request->file('product_image');
            $files->move(public_path().'/product/images/', $files->getClientOriginalName());
            $product_image = $files->getClientOriginalName();
            $products->product_image = $product_image;
        }

        // barcode image section
        $generate = new Picqer\Barcode\BarcodeGeneratorJPG();
        file_put_contents('product/barcodes/'. $product_code .'.jpg',
        $generate->getBarCode($product_code,
        $generate::TYPE_CODE_128, 3, 50));




        $products->product_name = $request->product_name;
        $products->price = $request->price;
        $products->alert_stock = $request->alert_stock;
        $products->quantity = $request->quantity;
        $products->product_code = $product_code;
        $products->barcode =  $product_code.'.jpg';
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
        $product_code = $request->product_code;
        $products = Product::find($products);


        // Image section
        if($request->hasFile('product_image')){

            if($products->product_image != '')
            {
                $prodImage_path = public_path(). '/product/images/' . $products->product_image;
                unlink($prodImage_path);
            }
            $files = $request->file('product_image');
            $files->move(public_path().'/product/images/', $files->getClientOriginalName());
            $product_image = $files->getClientOriginalName();
            $products->product_image = $product_image;
        }

        // Barcode image section
        if($request->product_code != '' && $request->product_code != $products->product_code)
        {

            $unique = Product::where('product_code', $product_code)->first();
            if($unique)
            {
                return redirect()->back()->with(['error','Product code is already Taken !!']);
            }

            if($products->barcode != '' or $products->barcode == '')
            {
                $barcode_path = public_path(). '/product/barcodes/' . $products->barcode;
                unlink($barcode_path);
            }

            $generate = new Picqer\Barcode\BarcodeGeneratorJPG();
            file_put_contents('/product/barcodes/'. $product_code .'.jpg',
            $generate->getBarCode($product_code,
            $generate::TYPE_CODE_128, 3, 50));

            $products->barcode =  $product_code.'.jpg';

        }

        $products->product_name = $request->product_name;
        $products->price = $request->price;
        $products->alert_stock = $request->alert_stock;
        $products->quantity = $request->quantity;
        $products->product_code = $product_code;
        $products->brand = $request->brand;
        $products->description = $request->description;
        $products->save();

        return redirect()->back()->with(['success','Product updated successfully']);
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
