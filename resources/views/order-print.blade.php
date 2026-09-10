 <!--This Page For Online Order Success Page-->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - #{{ $order->id }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* ප්‍රින්ට් කරන විට බටන්ස් ටික Hide කර පිටුව පිරිසිදුව තබා ගැනීමට */
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                background-color: white;
            }
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen p-4 md:p-8 flex flex-col items-center justify-center">

    <!-- Invoice Context Container -->
    <div class="max-w-2xl w-full bg-white rounded-2xl shadow-sm p-8 border border-gray-200">
        
        <!-- Header Section -->
        <div class="flex justify-between items-start border-b border-gray-100 pb-6 mb-6">
            <div>
                <h1 class="text-2xl font-black text-slate-800 tracking-tight">LAPTOP SHOP</h1>
                <p class="text-xs text-gray-400 font-bold mt-0.5">Official Retail Invoice</p>
            </div>
            <div class="text-right">
                <span class="text-blue-600 font-black text-xs tracking-wider uppercase bg-blue-50 px-2.5 py-1 rounded">INVOICE</span>
                <p class="text-xs text-slate-700 font-bold mt-2">Invoice NO: #{{ $order->id }}</p>
                <p class="text-[11px] text-gray-500 font-medium">Date: {{ $order->created_at ? $order->created_at->format('Y-m-d H:i A') : date('Y-m-d H:i A') }}</p>
            </div>
        </div>

        <!-- Meta Grid -->
        <div class="grid grid-cols-2 gap-4 mb-8 text-xs text-slate-600 font-semibold">
            <div>
                <p class="text-slate-800 font-extrabold mb-1">Customer Details:</p>
                <p>Name: <span class="text-slate-900 font-bold">{{ $order->name }}</span></p>
                <p>Phone: <span class="text-slate-900 font-bold">{{ $order->phone }}</span></p>
                <p class="mt-1">Address: <span class="text-slate-900 font-normal leading-tight">{{ $order->address }}</span></p>
            </div>
            <div class="text-right">
                <p class="text-slate-800 font-extrabold mb-1">Issued By:</p>
                <p class="text-slate-900">Online Checkout System</p>
                <p>Payment: <span class="bg-gray-100 text-slate-800 text-[10px] font-bold px-1.5 py-0.5 rounded uppercase">{{ $order->payment_method }}</span></p>
            </div>
        </div>

        <!-- Items Table Component -->
        <table class="w-full text-left border-collapse text-xs mb-6">
            <thead>
                <tr class="border-b border-slate-200 text-slate-500 uppercase font-bold tracking-wider">
                    <th class="py-3 font-extrabold">Item Description</th>
                    <th class="py-3 text-center font-extrabold">Qty</th>
                    <th class="py-3 text-right font-extrabold">Unit Price</th>
                    <th class="py-3 text-right font-extrabold">Amount</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-slate-700 font-semibold">
                <tr>
                    <td class="py-4">
                        <span class="text-slate-900 font-bold block">{{ $order->laptop->brand ?? 'Laptop' }}</span>
                        <span class="text-gray-400 text-[11px] font-medium">{{ $order->laptop->model ?? 'Specs' }}</span>
                    </td>
                    <td class="py-4 text-center text-slate-900">{{ $order->quantity }}</td>
                    <td class="py-4 text-right">Rs. {{ number_format($order->laptop->price ?? 0, 2) }}</td>
                    <td class="py-4 text-right text-slate-900">Rs. {{ number_format(($order->laptop->price ?? 0) * $order->quantity, 2) }}</td>
                </tr>
            </tbody>
        </table>

        <!-- Total Calculation Summary Block -->
        <div class="flex justify-end border-t border-gray-100 pt-4 mb-8">
            <div class="w-full max-w-xs space-y-2 text-xs text-slate-600 font-semibold">
                <div class="flex justify-between items-center text-sm pt-1">
                    <span class="text-slate-800 font-extrabold">Net Total:</span>
                    <span class="text-slate-900 font-black text-base">Rs. {{ number_format(($order->laptop->price ?? 0) * $order->quantity, 2) }}</span>
                </div>
            </div>
        </div>

        <!-- System Footer Note -->
        <p class="text-center text-[11px] text-gray-400 font-bold tracking-wide border-t border-dashed border-gray-200 pt-4 mb-6">
            Thank you for your business! Come again.
        </p>

        <!-- Functional Interfacing Action Buttons -->
        <div class="no-print flex items-center justify-center gap-3 pt-2">
            <button onclick="window.print()" class="bg-blue-600 hover:bg-blue-700 text-white font-extrabold text-[11px] tracking-wider uppercase px-4 py-2.5 rounded-xl transition shadow-sm">
                🖨️ Reprint Invoice
            </button>
            <a href="{{ route('order.success', $order->id) }}" class="bg-gray-500 hover:bg-gray-600 text-white font-extrabold text-[11px] tracking-wider uppercase px-4 py-2.5 rounded-xl transition shadow-sm">
                ← Back to Order
            </a>
        </div>

    </div>

    <!-- ⚡ AUTOMATIC PRINT TRIGGER SCRIPT -->
    <script>
        window.onload = function() {
            // පිටුව ලෝඩ් වුණු සැනින් බ්‍රවුසර් ප්‍රින්ට් මැෂින් එක පණ ගැන්වීම
            window.print();
        }
    </script>

</body>
</html>