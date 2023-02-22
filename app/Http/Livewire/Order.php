<?php

namespace App\Http\Livewire;

use App\Models\Cart;
use App\Models\Product;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Order extends Component
{

    public $orders, $products = [], $product_code, $message = '', $productIncart;
    public $pay_money = '', $balance = '';

    public function mount()
    {
        $this->products = Product::all();
        $this->productIncart = Cart::all();
    }

    public function insertoCart()
    {
        $countProduct = Product::where('id', $this->product_code)->first();

        if (!$countProduct) {
            return $this->message = 'Product not found';
        }
        $countCartProduct = Cart::where('product_id', $this->product_code)->count();

        if ($countCartProduct > 0) {
            return $this->message = 'Product ' . $countProduct->product_name . ' already exists in cart please add quantity';
        }

        $add_to_cart = new Cart;
        $add_to_cart->product_id = $countProduct->id;
        $add_to_cart->product_qty = 1;
        $add_to_cart->product_price = $countProduct->price;
        $add_to_cart->user_id = Auth::user()->id;
        $add_to_cart->save();
        $this->productIncart->prepend($add_to_cart);

        $this->product_code = '';
        return $this->message = "Product added successfully";
    }
    public function IncrementQty($cartId)
    {
        $carts = Cart::find($cartId);
        $carts->increment('product_qty', 1);
        $updatePrice = $carts->product_qty * $carts->product->price;
        $carts->update(['product_price' => $updatePrice]);
        $this->mount();
    }


    public function DecrementQty($cartId)
    {
        $carts = Cart::find($cartId);
        if ($carts->product_qty == 1) {
            return session()->flash('warning', 'Product ' . $carts->product->product_name . ' quantity can not be less than 1 or remove product in cart');
        }
        $carts->decrement('product_qty', 1);
        $updatePrice = $carts->product_qty * $carts->product->price;
        $carts->update(['product_price' => $updatePrice]);
        $this->mount();
    }

    public function removeProduct($cartID)
    {
        $deleteCart = Cart::find($cartID);
        if ($deleteCart->delete()) {
            return session()->flash('info', ' Product removed successfully from cart');
        }


        // $this->message = "Product removed successfully";
        $this->productIncart = $this->productIncart->except($cartID);
    }

    public function render()
    {
        if ($this->pay_money != '') {
            $totalAmount = $this->pay_money - $this->productIncart->sum('product_price');
            $this->balance = $totalAmount;
        }

        return view('livewire.order');
    }
}
