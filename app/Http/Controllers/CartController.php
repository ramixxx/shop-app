<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function addProductToCart222(Request $request) {
    	$data = $request->all();
    	$product = json_decode($data['product']);

    	$cart = new Cart;
    	$cart->uuid = $product->uuid;
    	$cart->session_id = $request->session()->get('_token');
    	$cart->quantity = $product->quantity;
        $cart->save();

    	return "Product saved successfully!";
    }

    public function addProductToCart(Request $request) {
        $data = $request->all();
        $product = json_decode($data['product']);
        session()->push('products', $product);

        return session()->get('products');
    }

    public function getCartProducts(Request $request) {
    	$session_id = Session::getId();
        print_r($session_id);
        // $cartItems = Cart::join('products', 'carts.uuid', '=', 'products.uuid')
     //           ->get(['products.*', 'carts.quantity']);

     //    $totalPrice = $cartItems->sum('price');
     //    $totalQuantity = $cartItems->sum('quantity');

     //    return response()->json([
     //        'cartData' => $cartItems,
     //        'totalPrice' => $totalPrice,
     //        'totalQuantity' => $totalQuantity
     //    ]);
    }

    public function clearCartProducts(Request $request) {
        $data = $request->session()->all();

    	Cart::where('session_id', $request->session()->get('_token'))->delete();
    	return "Cart deleted successfully!";
    }

    public function manageProductQuantity(Request $request) {
        $token = $request->session()->get('_token');
        Cart::where('session_id', $token)->delete();
        $data = $request->all();
        $products = json_decode($data['products']);
        if (!empty($products)) {
            foreach($products as $product) {
                $productsFinal[] = [
                    'uuid' => $product->uuid,
                    'session_id' => $token,
                    'quantity' => $product->quantity,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }
            Cart::insert($productsFinal);
        }
    }
}
