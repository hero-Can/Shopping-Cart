<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function cart(){
        return view('shopping-cart');
    }

    public function addProductsToCart($product_id){
        $product = Product::findOrFail($product_id);
        // add the product to cart
        \Cart::add(array(
            'id' => $product_id,
            'name' => $product->name,
            'price' => $product->price,
            'quantity' => 1,
            'attributes' => array(
                'image'=> $product->image,
            ),
            'associatedModel' => $product
        ));

        return redirect()->route('cart')->with('success','product has been added successfully to the cart');

    }
}
