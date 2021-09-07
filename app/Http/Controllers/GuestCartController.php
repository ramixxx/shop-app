<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GuestCart;

class GuestCartController extends Controller
{
    public function __construct(Request $request) {
        $this->request = $request;
    }

    public function addProductToGuestCart() {
        $data = $this->request->all();

        $product[] = [
            'uuid' => $data['product']['uuid'],
            'session_id' => \Session::getId(),
            'created_at' => now(),
            'updated_at' => now(),
            'quantity' => $data['product']['quantity']
        ];

        GuestCart::insert($product);

        return "Product saved successfully!";
    }

    public function getGuestCartProducts() {
        $cartItems = GuestCart::where('session_id', \Session::getId())
                ->join('products', 'guest_carts.uuid', '=', 'products.uuid')
                ->get(['products.*', 'guest_carts.quantity']);

        $totalPrice = $cartItems->sum('price');
        $totalQuantity = $cartItems->sum('quantity');

        return response()->json([
            'cartData' => $cartItems,
            'totalPrice' => $totalPrice,
            'totalQuantity' => $totalQuantity
        ]);
    }

    public function clearGuestCartProducts() {
        GuestCart::where('session_id', \Session::getId())->delete();
        return "Cart deleted successfully!";
    }

    public function manageGuestCartProductQuantity() {
        GuestCart::where('session_id', \Session::getId())->delete();
        $data = $this->request->all();
        $products = json_decode($data['products']);
        if (!empty($products)) {
            foreach($products as $product) {
                $productsFinal[] = [
                    'uuid' => $product->uuid,
                    'session_id' => \Session::getId(),
                    'quantity' => $product->quantity,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
                GuestCart::insert($productsFinal);
            }
        }
    }
}
