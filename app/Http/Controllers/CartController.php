<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function __construct(Request $request) {
        $this->request = $request;
    }

    public function currentUserId() {
        return $this->request->user()->id;
    }

    public function addProductToCart() {
        $data = $this->request->all();

        $product[] = [
            'uuid' => $data['product']['uuid'],
            'user_id' => $this->currentUserId(),
            'created_at' => $data['product']['created_at'],
            'updated_at' => $data['product']['updated_at'],
            'quantity' => $data['product']['quantity']
        ];

        Cart::insert($product);

        return "Product saved successfully!";
    }

    public function getCartProducts() {
        $cartItems = Cart::where('user_id', $this->currentUserId())
                ->join('products', 'carts.uuid', '=', 'products.uuid')
                ->get(['products.*', 'carts.quantity']);

        $totalPrice = $cartItems->sum('price');
        $totalQuantity = $cartItems->sum('quantity');

        return response()->json([
            'cartData' => $cartItems,
            'totalPrice' => $totalPrice,
            'totalQuantity' => $totalQuantity
        ]);
    }

    public function clearCartProducts() {
    	Cart::where('user_id', $this->currentUserId())->delete();
    	return "Cart deleted successfully!";
    }

    public function manageProductQuantity() {
        Cart::where('user_id', $this->currentUserId())->delete();
        $data = $this->request->all();
        $products = json_decode($data['products']);
        if (!empty($products)) {
            foreach($products as $product) {
                $productsFinal[] = [
                    'uuid' => $product->uuid,
                    'user_id' => $this->currentUserId(),
                    'quantity' => $product->quantity,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
                Cart::insert($productsFinal);
            }
        }
    }
}
