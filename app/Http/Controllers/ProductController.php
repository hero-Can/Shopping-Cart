<?php

namespace App\Http\Controllers;

use Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(){
        $products = Product::all();
        $count_products_cart = Cart::getContent()->count();
        return view('product-cards',compact('products','count_products_cart'));
    }
}
