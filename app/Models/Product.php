<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order_Detail;
use App\Models\Cart;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';
    protected $fillable = ['product_name', 'price', 'alert_stock','quatity','brand','description'];

    public function orderdetail()
    {
        return $this->hasMany(Order_Detail::class);
    }
    public function cart()
    {
        return $this->hasMany(Cart::class);
    }
}
