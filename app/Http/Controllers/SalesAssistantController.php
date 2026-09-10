<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Laptop;
use App\Models\Sale; 
use Illuminate\Support\Facades\Auth;

class SalesAssistantController extends Controller
{
    public function create()
    {
        $laptops = Laptop::where('stock', '>', 0)->get();
        return view('assistant.counter_sale', compact('laptops'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'laptop_id' => 'required|exists:laptops,id',
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'quantity' => 'required|integer|min:1',
        ]);

        $laptop = Laptop::findOrFail($request->laptop_id);

        if ($laptop->stock < $request->quantity) {
            return redirect()->back()->withErrors(['quantity' => 'Requested quantity exceeds available stock!'])->withInput();
        }

        $totalPrice = $laptop->price * $request->quantity;

        // $sale එකකට අලුත් රෙකෝඩ් එක සේව් කරගන්නවා
        $sale = Sale::create([
            'customer_name' => $request->customer_name,
            'customer_phone' => $request->customer_phone,
            'laptop_id' => $laptop->id,
            'quantity' => $request->quantity,
            'total_price' => $totalPrice,
            'user_id' => Auth::id(),
        ]);

        $laptop->decrement('stock', $request->quantity);

        // වෙනස් කළ තැන: කෙලින්ම Invoice ප්‍රින්ට් කරන පේජ් එකට රීඩිරෙක්ට් කරනවා ID එකත් එක්ක
        return redirect()->route('assistant.invoice.print', $sale->id);
    }

    // അලුතින් එකතු කළ ෆන්ක්ෂන් එක - බිල්පත පෙන්වීම සඳහා
    public function printInvoice($id)
    {
        // බිල්පතේ විස්තර සහ ඒකට අදාළ ලැප්ටොප්, යූසර් විස්තර ඩේටාබේස් එකෙන් ගන්නවා
        $sale = Sale::with('laptop', 'user')->findOrFail($id);
        return view('assistant.invoice', compact('sale'));
    }

    // === මෙතැන් සිට පහළට අලුතින් එකතු කරන ලද කොටස වේ ===
    public function mySales()
    {
        // 1. ලොග් වී සිටින සේල්ස් ඇසිස්ටන්ට්ගේ ID එකට අදාළ සේල්ස් පමණක් ලබා ගැනීම
        $mySales = Sale::where('user_id', auth()->id())
                       ->orderBy('created_at', 'desc')
                       ->paginate(10); // Pagination එකත් එක්කම

        // 2. එම ඇසිස්ටන්ට් පමණක් උපයා ඇති මුළු ආදායම ගණනය කිරීම
        $myTotalEarnings = Sale::where('user_id', auth()->id())->sum('total_price');

        // 3. දත්ත ටික View එකට යැවීම
        return view('assistant.my_sales', compact('mySales', 'myTotalEarnings'));
    }
}