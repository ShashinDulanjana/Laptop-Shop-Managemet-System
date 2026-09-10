<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Successful - Laptop Shop</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
</head>
<body class="bg-gray-100 min-h-screen font-sans antialiased flex flex-col justify-between">

    <!-- Navbar Layout Match -->
    <nav class="bg-[#1a202c] px-6 py-3 flex justify-between items-center sticky top-0 z-50">
        <a href="#" class="text-[#3498db] font-bold text-xl uppercase tracking-wider">LAPTOP <span class="text-white">SHOP</span></a>
        <a href="{{ route('customer.shop') }}" class="bg-slate-700 hover:bg-slate-600 text-white font-bold text-xs py-2 px-4 rounded-lg tracking-wide uppercase transition">
            ← Back to Shop
        </a>
    </nav>

    <!-- Main Content Context Card -->
    <div class="py-12 flex-grow flex items-center justify-center px-4">
        <div class="max-w-2xl w-full bg-white rounded-3xl shadow-sm border border-gray-100 p-8 md:p-10 text-center">
            
            <!-- 🎉 Order Successful Banner (As observed in Screenshot 625) -->
            <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-lg text-blue-800">
    <p class="font-bold">✅ Order Placed Successfully!</p>
    <p class="mt-1">Your order will be delivered within 3 days.</p>
    <p class="text-sm mt-2">
        For more details, contact Laptop Shop: 
        <a href="tel:+94762450093" class="font-bold underline text-blue-700 hover:text-blue-900">
            076 245 0093
        </a>
    </p>
</div>

            <!-- Order Reference Identity Brief -->
            <div class="mb-8 text-left bg-gray-50 rounded-2xl p-6 border border-gray-100">
                <h3 class="text-slate-800 font-bold text-base mb-4 pb-2 border-b border-gray-200 flex items-center gap-2">
                    📦 Order Summaries & Info
                </h3>
                <div class="space-y-2 text-sm text-slate-600 font-semibold">
                    <p class="flex justify-between"><span>Order ID Reference:</span> <span class="text-slate-900 font-black">#ORD-00{{ $order->id }}</span></p>
                    <p class="flex justify-between"><span>Customer Name:</span> <span class="text-slate-900 font-bold">{{ $order->customer_name ?? 'Valued Customer' }}</span></p>
                    <p class="flex justify-between"><span>Item Purchased:</span> <span class="text-slate-900 font-bold">{{ $order->laptop->brand ?? 'Laptop' }} {{ $order->laptop->model ?? '' }}</span></p>
                    <p class="flex justify-between pb-2"><span>Quantity Ordered:</span> <span class="text-slate-900 font-bold">{{ $order->quantity ?? '1' }}</span></p>
                    <div class="pt-2 border-t border-dashed border-gray-200 flex justify-between items-center text-base">
                        <span class="text-slate-800 font-bold">Total Net AmountPaid:</span>
<span class="text-blue-600 font-black">Rs. {{ number_format((($order->laptop->price ?? $order->price ?? $sale->laptop->price ?? 145000) * ($order->quantity ?? $sale->quantity ?? 1)), 2) }}</span>
                    </div>
                </div>
            </div>

            <!-- User Action Prompt Functional Buttons -->
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                
                <!-- Amber Invoice Download Button -->
                <a href="{{ route('order.invoice.download', $order->id) }}"
                   style="background-color: #f59e0b; color: white; font-weight: 800; padding: 14px 28px; border-radius: 12px; text-decoration: none; display: inline-flex; align-items: center; justify-center; box-shadow: 0 10px 15px -3px rgba(245, 158, 11, 0.2); transition: 0.3s; text-transform: uppercase; font-size: 11px; letter-spacing: 1px; width: 100%; max-width: 240px;"
                   onmouseover="this.style.backgroundColor='#d97706'; this.style.transform='translateY(-2px)'"
                   onmouseout="this.style.backgroundColor='#f59e0b'; this.style.transform='translateY(0px)'">
                     📥 Download Invoice
                </a>

                <!-- Standard Green Back to Catalog Button -->
                <a href="{{ route('customer.shop') }}"
                   style="background-color: #10b981; color: white; font-weight: 800; padding: 14px 28px; border-radius: 12px; text-decoration: none; display: inline-flex; align-items: center; justify-center; box-shadow: 0 10px 15px -3px rgba(16, 185, 129, 0.2); transition: 0.3s; text-transform: uppercase; font-size: 11px; letter-spacing: 1px; width: 100%; max-width: 240px;"
                   onmouseover="this.style.backgroundColor='#059669'; this.style.transform='translateY(-2px)'"
                   onmouseout="this.style.backgroundColor='#10b981'; this.style.transform='translateY(0px)'">
                     🛍️ Continue Shopping
                </a>

            </div>

        </div>
    </div>

    <!-- Simple Footer Copyright Line -->
    <footer class="bg-gray-200 text-center py-4 text-xs font-semibold text-slate-500 tracking-wide border-t border-gray-300">
        &copy; {{ date('Y') }} Laptop Shop Inventory Management System. All Rights Reserved.
    </footer>

</body>
</html>