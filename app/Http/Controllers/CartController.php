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

    	$cartItems = Cart::join('products', 'carts.uuid', '=', 'products.uuid')->get(['products.*']);
    	view('cart', ['cartData' => $cartItems])->render();

    	$value = $request->session()->get('cartItemCount');
    	$request->session()->put('cartItemCount', $value + 1);
    	return $request->session()->get('cartItemCount');
    }

    public function getCartProducts(Request $request) {
    	$cartItems = Cart::join('products', 'carts.uuid', '=', 'products.uuid')
               ->get(['products.*']);
               // print_r($cartItems->isEmpty());
        if($cartItems->isEmpty() == '1') {
            $html = view('cart', ['emptyCart' => 'You dont have anything added to cart.'])->render();
			return $html;
        }
        $totalPrice = $cartItems->sum('price');

    	$html = view('cart', ['cartData' => $cartItems, 'totalPrice' => $totalPrice])->render();
		return $html;
    }

    public function clearCartProducts(Request $request) {
    	Cart::where('session_id', $request->session()->get('_token'))->delete();
    	$request->session()->forget('cartItemCount');
    	$cartItems = Cart::join('products', 'carts.uuid', '=', 'products.uuid')->get(['products.*']);
    	$html = view('cart', ['cartData' => $cartItems])->render();
    	return $html;
    }
}
