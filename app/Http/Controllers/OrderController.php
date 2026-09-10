<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Laptop;

class OrderController extends Controller
{
    public function confirm(Request $request)
    {
        // 1. දත්ත සහ OTP එක නිවැරදිදැයි පරීක්ෂා කිරීම (Server-side Validation)
        $request->validate([
            'laptop_id' => 'required|exists:laptops,id',
            'name' => 'required|string|max:255',
            'phone' => 'required|string',
            'address' => 'required|string',
            'quantity' => 'required|integer|min:1',
            'payment_method' => 'required|in:COD,CARD',
            // මෙන්න අපි අලුතින්ම දාපු Server-side OTP Verification එක!
            'otp' => 'required|in:1234', 
        ]);

        if ($request->payment_method == 'CARD') {
            $request->validate([
                'card_name' => 'required|string',
                'card_number' => 'required|string',
                'card_expiry' => 'required|string',
                'card_cvc' => 'required|string',
            ]);
        }

        // 2. සියල්ල නිවැරදි නම් දත්ත SQL Database එකට සේව් කිරීම
        
        // 🔴 ලැප්ටොප් එක සොයා ගැනීම
        $laptop = Laptop::findOrFail($request->laptop_id);

        // 🔐 FIXED: ස්ටොක් එක ප්‍රමාණවත්දැයි පරීක්ෂා කිරීම (Server-side Stock Validation)
        // පාරිභෝගිකයා ඉල්ලන ප්‍රමාණයට වඩා ස්ටොක් අඩු නම්, ඇණවුම බ්ලොක් කර Error එකක් පෙන්වයි.
        if ($laptop->stock < $request->quantity) {
            return redirect()->back()
                ->withErrors(['quantity' => 'Sorry! Only ' . ($laptop->stock <= 0 ? 0 : $laptop->stock) . ' items are remaining in stock for this laptop.'])
                ->withInput();
        }

        // ඇණවුම් කල ප්‍රමාණය ස්ටොක් එකෙන් අඩු කර සේව් කිරීම
        $laptop->stock -= $request->quantity;
        $laptop->save();

        // 🔄 සටහන: අලුත් Success Page එකට ID එක යැවීම සඳහා Order එක $order විචල්‍යයකට ලබා ගත්තා
        $order = Order::create([
            'laptop_id' => $request->laptop_id,
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'quantity' => $request->quantity,
            'payment_method' => $request->payment_method,
            'card_name' => $request->card_name,
            'card_number' => $request->card_number ? substr(str_replace(' ', '', $request->card_number), -4) : null, 
            'card_expiry' => $request->card_expiry,
            'card_cvc' => $request->card_cvc, 
            'status' => 'Pending'
        ]);
        

        // 3. සාර්ථකත්වයේ පණිවිඩය සමඟ නව පිටුවට (Order Success Page) රීඩිරෙක්ට් කිරීම
        return redirect()->route('order.success', $order->id);
    }

    // 👥 NEW: Online Order Success View Handler
    public function orderSuccess($id)
    {
        // ඕඩර් එක සහ ඒකට අදාළ ලැප්ටොප් එකේ විස්තර එකවර ලබා ගැනීම
        $order = Order::with('laptop')->findOrFail($id);
        
        return view('order-success', compact('order'));
    }

    // 📥 UPDATED: Online Order Invoice Print & PDF View
    public function downloadInvoice($id)
    {
        // ඕඩර් එක සහ ඒකට අදාළ ලැප්ටොප් එකේ විස්තර ලබා ගැනීම
        $order = Order::with('laptop')->findOrFail($id);
        
        // කස්ටමර් සඳහා සාදාගන්නා නව ප්‍රින්ට් බ්ලේඩ් එකට දත්ත යැවීම
        return view('order-print', compact('order'));
    }
    
    // 🌐 NEW: Admin Online Orders Log & Revenue Dashboard
    public function onlineOrders()
    {
        // වෙබ් සයිට් එකෙන් ආපු COD සහ CARD ඔන්ලයින් ඇණවුම් පමණක් ඩේටාබේස් එකෙන් ලබා ගැනීම
        $onlineOrders = Order::with('laptop')
            ->whereIn('payment_method', ['COD', 'CARD'])
            ->latest()
            ->get();

// 💳 COD ඒවා DELIVERED වුණාමත්, CARD ඒවා (CANCELLED නොවන) හැම වෙලාවකමත් Revenue එකට එකතු කිරීම
$totalOnlineRevenue = $onlineOrders->filter(function ($order) {
    $status = strtoupper($order->status ?? 'PENDING');
    $paymentMethod = strtoupper($order->payment_method ?? '');

    // Condition 1: ඕඩර් එක Delivered නම් (COD හෝ CARD ඕනෑම එකක්)
    // Condition 2: හෝ Payment එක CARD වෙලා ඒක Cancelled නොවන ඕනෑම අවස්ථාවක
    return $status == 'DELIVERED' || ($paymentMethod == 'CARD' && $status != 'CANCELLED');
})->reduce(function ($carry, $order) {
    return $carry + (($order->laptop->price ?? 0) * $order->quantity);
}, 0);

        return view('admin.online-orders', compact('onlineOrders', 'totalOnlineRevenue'));
    }

    public function updateStatus(Request $request, $id)
{
    // ඔයාගේ ටේබල් එකේ නම අනුව Order හෝ Sale පාවිච්චි කරන්න
    $order = \App\Models\Sale::findOrFail($id); 
    $order->status = $request->status;
    $order->save();

    return back()->with('success', 'Order status updated successfully!');
}
}