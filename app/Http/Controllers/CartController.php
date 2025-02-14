<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function cart(){
        $items = \Cart::getContent()->sort();
        $subTotal = \Cart::getSubTotal();
        $total = \Cart::getTotal();
        return view('shopping-cart',compact('items','subTotal','total'));
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

    public function incrementQuantity($product_id) {
                // increment the item on cart
        \Cart::update($product_id,[
            'quantity' => +1,
        ]);

        return back()->with('success','quantity increment successfully');
    }

    public function decrementQuantity($product_id) {
                // update the item on cart
        \Cart::update($product_id,[
            'quantity' => -1,
        ]);

        return back()->with('success','quantity decrement successfully');
    }

    public function removeProductFromCart($product_id) {
       // delete an item on cart
        \Cart::remove($product_id);
        return back()->with('success','product deleted successfully');
}
}
