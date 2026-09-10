<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addToCart(Request $request, $id)
    {
        // Session eken parana cart data gannawa, nathnam empty array ekak gannawa
        $cart = session()->get('cart', []);

        // Laptop eka kalin add karala thiyenam quantity wadi karanawa
        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            // Aluth laptop ekak nam cart array ekata add karanawa
            $cart[$id] = [
                "brand" => $request->brand,
                "model" => $request->model,
                "price" => $request->price,
                "image" => $request->image,
                "quantity" => 1
            ];
        }

        // Update wecha array eka aith session ekata dannawa
        session()->put('cart', $cart);

        // Subtotal calculation
        $total = 0;
        foreach($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // Frontend ekata response eka JSON vidiyata yawanawa
        return response()->json([
            'success' => true,
            'cartCount' => count($cart),
            'cart' => $cart,
            'total' => number_format($total, 0)
        ]);
    }

    // === මෙතැන් සිට අලුතින් එකතු කල කොටස (Added Remove Item Logic) ===
    public function removeFromCart($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        // ඉතිරි වී ඇති මුළු මුදල නැවත ගණනය කිරීම
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // Frontend එක බලාපොරොත්තු වන JSON Response එකම ලබාදීම
        return response()->json([
            'success' => true,
            'cartCount' => count($cart),
            'cart' => $cart,
            'total' => number_format($total, 0)
        ]);
    }

    public function checkout()
{
    $cart = session()->get('cart', []);

    // Cart එක හිස් නම් ආපහු හරවා යැවීම / If cart is empty, redirect back
    if (empty($cart)) {
        return redirect()->back()->with('error', 'Your cart is empty!');
    }

    // ඔයාගේ checkout blade එක තියෙන තැන අනුව view path එක වෙනස් කරගන්න 
    // Return checkout view (Make sure this matches your checkout blade file name/location)
    return view('customer.checkout', compact('cart')); 
}
}