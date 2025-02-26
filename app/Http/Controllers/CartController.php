<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function cart(){

        // Remove Specific Cart Condition
        // $conditionName = 'VAT 12.5%';
        // \Cart::removeCartCondition($conditionName);
        //  dd(\Cart::getConditions(),\Cart::getTotal(),\Cart::getSubTotal());

        $condition = new \Darryldecode\Cart\CartCondition(array(
            'name' => 'VAT 5%',
            'type' => 'tax',
            'target' => 'subtotal', // this condition will be applied to cart's subtotal when getSubTotal() is called.
            'value' => '5%',
            'order' => 1,
            'attributes' => array( // attributes field is optional
                'description' => 'Value added tax',
                'more_data' => 'more data here',
            )
        ));
        \Cart::condition($condition);
        $items = \Cart::getContent()->sort();
        // $subTotal = \Cart::getSubTotal();
        $subTotal = \Cart::getSubTotalWithoutConditions(); //Original price
        $tax_price = $condition->getCalculatedValue($subTotal); // conditionCalculatedValue
        // $tax_price = ((str_replace('%', '',$tax_value)) * $subTotal)/ 100;
        $tax_value = \Cart::getCondition('VAT 5%')->getValue();
         $total = \Cart::getTotal();
        //  $total = $subTotal + $tax_price;
        //   dd(\Cart::getConditions(),\Cart::getTotal(),\Cart::getSubTotal(),\Cart::getSubTotalWithoutConditions());

        $coupon_name = null;
        $coupon_value = 0;
        $coupon_price = 0;

        if (\Cart::getCondition('COUPON 101')) {
            $coupon_name = \Cart::getCondition('COUPON 101')->getName();
            $coupon_value = \Cart::getCondition('COUPON 101')->getValue();
            $coupon_price = \Cart::getCondition('COUPON 101')->getCalculatedValue($subTotal);
        }

        //  dd(\Cart::getConditions(),$subTotal,\Cart::getsubTotal(),$total,$coupon_price);
//    Final Calculation After Fixing the Order:

//     Initial Subtotal = 20.00

//     VAT (5%) applied first:
//     5% of 20.00 = 1.00
//     Subtotal After VAT = 20.00 + 1.00 = 21.00

//     Coupon (5%) applied second:
//     5% discount on 21.00 = 1.05
//     Final Total = 21.00 - 1.05 = 19.95
        return view('shopping-cart',compact('items','subTotal','total','tax_value','tax_price','coupon_name','coupon_value','coupon_price'));
    }

    public function addProductsToCart($product_id){
        $product = Product::findOrFail($product_id);
        // add single condition on a cart bases
        // $condition = new \Darryldecode\Cart\CartCondition(array(
        //     'name' => 'VAT 5%',
        //     'type' => 'tax',
        //     'target' => 'SubTotalWithoutConditions', // this condition will be applied to cart's subtotal when getSubTotal() is called.
        //     'value' => '5%',
        //     'attributes' => array( // attributes field is optional
        //         'description' => 'Value added tax',
        //         'more_data' => 'more data here',
        //     )
        // ));
        // \Cart::condition($condition);
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

    public function clearCart() {
        \Cart::clear();
         \Cart::removeCartCondition('COUPON 101');
         return back()->with('success','products deleted successfully');
     }

     public function applyCoupon(Request $request){
        $coupon101 = new \Darryldecode\Cart\CartCondition(array(
            'name' => 'COUPON 101',
            'type' => 'coupon',
            'target' => 'subtotal',
            'value' => '-5%',
            'order' => 2,
        ));
        if ($request->coupon == "COUPON101") {
            \Cart::condition($coupon101);
            return back()->with('success','coupon added successfully');
        }
        // dd(\Cart::getConditions(),\Cart::getTotal(),\Cart::getCondition('COUPON 101')->getValue(),$coupon101->getCalculatedValue(\Cart::getSubTotal()));
        //  \Cart::removeCartCondition('COUPON 101');
        return back()->with('error','coupon not correct');
     }
}
