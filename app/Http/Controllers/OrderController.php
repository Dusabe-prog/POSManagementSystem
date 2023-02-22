<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\Order_Detail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        $orders = Order::all();
        //Last order detail
        $lastID = Order_Detail::max('order_id');
        $order_receipt = Order_Detail::where('order_id', $lastID)->get();

        return view('orders.index', ['products' => $products, 'orders' => $orders, 'order_receipt' => $order_receipt]);
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
        // return $request->all();
        DB::transaction(function () use ($request) {

            // order modal
            $orders =  new Order;
            $orders->name =  $request->customer_name;
            $orders->address =  $request->customer_phone;
            $orders->save();
            $order_id = $orders->id;

            // Order details modal

            for ($product_id = 0; $product_id < count($request->product_id); $product_id++) {

                $order_detail = new Order_Detail;
                $order_detail->order_id = $order_id;
                $order_detail->product_id = $request->product_id[$product_id];
                $order_detail->unitprice = $request->price[$product_id];
                $order_detail->quantity = $request->quantity[$product_id];
                $order_detail->discount = $request->discount[$product_id];
                $order_detail->amount = $request->total_amount[$product_id];
                $order_detail->save();
            }


            // Transaction modal

            $transaction = new Transaction;
            $transaction->order_id = $order_id;
            $transaction->user_id = Auth::user()->id;
            $transaction->balance = $request->balance;
            $transaction->paid_amount = $request->paid_amount;
            $transaction->payment_method = $request->payment_method;
            $transaction->transac_amount = $order_detail->amount;
            $transaction->transac_date = date("Y-m-d");
            $transaction->save();

            Cart::where('user_id', Auth::user()->id)->delete();

            //Last Order History
            $products = Product::all();
            $order_detail = Order_Detail::where('order_id', $order_id)->get();
            $orderedBy = Order::where('id', $order_id)->get();

            return view(
                'orders.index',
                [
                    'products' => $products,
                    'order_detail' => $order_detail,
                    'customer_orders' => $orderedBy,
                ]
            );
        });

        return back()->with(" Product orders fails to inserted check your inputs");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
