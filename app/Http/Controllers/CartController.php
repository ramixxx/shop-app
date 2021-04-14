<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;

class CartController extends Controller
{
    public function addProductToCart(Request $request) {
    	$data = $request->all();
    	$product = json_decode($data['product']);

    	$cart = new Cart;
    	$cart->uuid = $product->uuid;
    	$cart->session_id = $request->session()->get('_token');
    	$cart->save();

    	return "Product saved successfully!";
    }

    public function getCartProducts(Request $request) {
    	$cartItems = Cart::join('products', 'carts.uuid', '=', 'products.uuid')
               ->get(['products.*']);

        $totalPrice = $cartItems->sum('price');

        return response()->json([
            'cartData' => $cartItems,
            'totalPrice' => $totalPrice
        ]);
    }

    public function clearCartProducts(Request $request) {
    	Cart::where('session_id', $request->session()->get('_token'))->delete();
    	return "Cart deleted successfully!";
    }
}
