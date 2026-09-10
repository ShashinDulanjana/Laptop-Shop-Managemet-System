<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - #{{ $sale->id }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .no-print { display: none; }
            body { background: white; color: black; }
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen py-10">

    <div class="max-w-2xl mx-auto bg-white p-8 rounded-xl shadow-md border border-gray-200" id="invoice">
        <!-- Header -->
        <div class="flex justify-between items-center border-b pb-6 mb-6">
            <div>
                <h1 class="text-2xl font-bold text-slate-800 tracking-wide">LAPTOP SHOP</h1>
                <p class="text-xs text-gray-500">Official Retail Invoice</p>
            </div>
            <div class="text-right">
                <h2 class="text-lg font-bold text-blue-600">INVOICE</h2>
                <p class="text-xs text-gray-500">Invoice NO: #{{ $sale->id }}</p>
                <p class="text-xs text-gray-500">Date: {{ $sale->created_at->format('Y-m-d H:i A') }}</p>
            </div>
        </div>

        <!-- Details -->
        <div class="grid grid-cols-2 gap-4 mb-8 text-sm">
            <div>
                <h5 class="font-bold text-gray-700 mb-1">Customer Details:</h5>
                <p class="text-gray-600"><span class="font-medium">Name:</span> {{ $sale->customer_name }}</p>
                <p class="text-gray-600"><span class="font-medium">Phone:</span> {{ $sale->customer_phone }}</p>
            </div>
            <div class="text-right">
                <h5 class="font-bold text-gray-700 mb-1">Issued By:</h5>
                <p class="text-gray-600">{{ $sale->user->name }} (Sales Assistant)</p>
            </div>
        </div>

        <!-- Table -->
        <table class="w-full text-left border-collapse mb-8 text-sm">
            <thead>
                <tr class="bg-gray-50 border-b">
                    <th class="p-3 font-bold text-gray-700">Item Description</th>
                    <th class="p-3 font-bold text-gray-700 text-center">Qty</th>
                    <th class="p-3 font-bold text-gray-700 text-right">Unit Price</th>
                    <th class="p-3 font-bold text-gray-700 text-right">Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr class="border-b">
                    <td class="p-3">
                        <span class="font-bold text-gray-800">{{ $sale->laptop->brand }}</span>
                        <p class="text-xs text-gray-500">{{ $sale->laptop->model }}</p>
                    </td>
                    <td class="p-3 text-center text-gray-800">{{ $sale->quantity }}</td>
                    <td class="p-3 text-right text-gray-800">Rs. {{ number_format($sale->laptop->price, 2) }}</td>
                    <td class="p-3 text-right font-bold text-gray-800">Rs. {{ number_format($sale->total_price, 2) }}</td>
                </tr>
            </tbody>
        </table>

        <!-- Total -->
        <div class="flex justify-end mb-10">
            <div class="w-1/2 text-right border-t pt-4">
                <div class="flex justify-between font-extrabold text-lg text-slate-900">
                    <span>Net Total:</span>
                    <span>Rs. {{ number_format($sale->total_price, 2) }}</span>
                </div>
            </div>
        </div>

        <!-- Footer Note -->
        <div class="text-center text-xs text-gray-400 border-t pt-4">
            Thank you for your business! Come again.
        </div>

        <!-- Control Buttons (Hidden during Print) -->
        <div class="mt-8 flex gap-4 justify-center no-print">
            <button onclick="window.print()" class="bg-blue-600 text-white px-6 py-2 rounded-lg font-bold hover:bg-blue-700 transition">
                🖨️ Reprint Invoice
            </button>
            <a href="{{ route('assistant.counter_sale') }}" class="bg-gray-500 text-white px-6 py-2 rounded-lg font-bold hover:bg-gray-600 transition">
                ← Back to Counter Sales
            </a>
        </div>
    </div>

    <!-- Auto Print Script -->
    <script>
        // පිටුව ලෝඩ් වුණු සැනින් Print Dialog එක ඕපන් කරවයි
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>