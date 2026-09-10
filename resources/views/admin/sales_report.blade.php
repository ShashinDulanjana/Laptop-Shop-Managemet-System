<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Sales Report</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen font-sans">

    <nav class="bg-slate-800 text-white p-4 shadow-md">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <h1 class="text-xl font-bold tracking-wider">💻 LAPTOP SHOP (ADMIN)</h1>
            <a href="/dashboard" class="bg-gray-600 hover:bg-gray-700 px-4 py-2 rounded-lg text-sm font-semibold transition">Dashboard</a>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 py-8">
        <h2 class="text-3xl font-extrabold text-slate-800 mb-8">📊 Overall Sales Report</h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-medium uppercase">Total Revenue</p>
                    <h3 class="text-2xl font-bold text-emerald-600 mt-1">Rs. {{ number_format($totalRevenue, 2) }}</h3>
                </div>
                <div class="p-3 bg-emerald-50 text-emerald-600 rounded-lg text-2xl">💰</div>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-medium uppercase">Total Invoices Issued</p>
                    <h3 class="text-2xl font-bold text-blue-600 mt-1">{{ $totalSalesCount }}</h3>
                </div>
                <div class="p-3 bg-blue-50 text-blue-600 rounded-lg text-2xl">📄</div>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-medium uppercase">Total Laptops Sold</p>
                    <h3 class="text-2xl font-bold text-amber-600 mt-1">{{ $totalLaptopsSold }} Items</h3>
                </div>
                <div class="p-3 bg-amber-50 text-amber-600 rounded-lg text-2xl">📦</div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="p-5 border-b border-gray-100 bg-gray-50">
                <h4 class="font-bold text-slate-700 text-lg">Recent Transactions Log</h4>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-sm">
                    <thead>
                        <tr class="bg-gray-100 text-gray-700 uppercase font-semibold text-xs border-b">
                            <th class="p-4">Invoice ID</th>
                            <th class="p-4">Date & Time</th>
                            <th class="p-4">Sales Assistant</th>
                            <th class="p-4">Customer Details</th>
                            <th class="p-4">Laptop Model</th>
                            <th class="p-4 text-center">Qty</th>
                            <th class="p-4 text-right">Total Price</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-gray-600">
                        @forelse($sales as $sale)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="p-4 font-bold text-blue-600">#{{ $sale->id }}</td>
                                <td class="p-4">{{ $sale->created_at->format('Y-m-d h:i A') }}</td>
                                <td class="p-4">
                                    <span class="bg-slate-100 text-slate-800 text-xs px-2.5 py-1 rounded-md font-medium">
                                        👤 {{ $sale->user->name }}
                                    </span>
                                </td>
                                <td class="p-4">
                                    <div class="font-medium text-gray-800">{{ $sale->customer_name }}</div>
                                    <div class="text-xs text-gray-400">{{ $sale->customer_phone }}</div>
                                </td>
                                <td class="p-4">
                                    <div class="font-bold text-gray-800">{{ $sale->laptop->brand }}</div>
                                    <div class="text-xs text-gray-500">{{ $sale->laptop->model }}</div>
                                </td>
                                <td class="p-4 text-center font-medium">{{ $sale->quantity }}</td>
                                <td class="p-4 text-right font-bold text-slate-900">Rs. {{ number_format($sale->total_price, 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="p-8 text-center text-gray-400 font-medium">
                                    No sales transactions recorded yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>
</html>