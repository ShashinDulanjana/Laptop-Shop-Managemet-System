<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Sales History</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .custom-navbar { background-color: #1a202c !important; padding: 12px 25px; display: flex; justify-content: space-between; align-items: center; }
        .brand-text { color: #3498db; font-weight: bold; font-size: 1.5rem; text-decoration: none; text-transform: uppercase; }
        .logout-btn { background-color: #ff4d4d !important; color: white !important; font-weight: bold; border-radius: 8px; padding: 8px 20px; border: none; }
    </style>
</head>
<body class="bg-gray-100 min-h-screen font-sans antialiased">

<nav class="custom-navbar">
    <div>
        <a href="{{ url('/dashboard') }}" class="brand-text">LAPTOP <span class="text-white">SHOP</span></a>
    </div>
    <div>
        <a href="{{ url('/dashboard') }}" class="btn btn-outline-light btn-sm fw-bold px-3 py-2 rounded-3">Dashboard</a>
    </div>
</nav>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        <div class="px-4 mb-8">
            <h2 class="font-black text-3xl text-slate-800 tracking-tight flex items-center gap-2">
                📊 My Sales History
            </h2>
            <p class="text-gray-500 text-sm mt-1">Track and manage your personal laptop sales logs.</p>
        </div>

        <!-- Personal Summary Card -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10 px-4">
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 flex justify-between items-center">
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">My Total Sales Value</p>
                    <h3 class="text-2xl font-black text-emerald-600 mt-1">Rs. {{ number_format($myTotalEarnings, 2) }}</h3>
                </div>
                <div class="bg-emerald-50 p-4 rounded-2xl text-2xl">💰</div>
            </div>

            <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 flex justify-between items-center">
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Invoices Issued By Me</p>
                    <h3 class="text-2xl font-black text-blue-600 mt-1">{{ $mySales->total() }} Invoices</h3>
                </div>
                <div class="bg-blue-50 p-4 rounded-2xl text-2xl">📄</div>
            </div>
        </div>

        <!-- Personal Sales Table Log -->
        <div class="px-4">
            <div class="bg-white rounded-3xl overflow-hidden shadow-sm border border-gray-100">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100">
                                <th class="p-4 text-xs font-bold text-gray-500 uppercase">Invoice ID</th>
                                <th class="p-4 text-xs font-bold text-gray-500 uppercase">Date & Time</th>
                                <th class="p-4 text-xs font-bold text-gray-500 uppercase">Customer Details</th>
                                <th class="p-4 text-xs font-bold text-gray-500 uppercase">Laptop Model</th>
                                <th class="p-4 text-xs font-bold text-gray-500 uppercase text-center">QTY</th>
                                <th class="p-4 text-xs font-bold text-gray-500 uppercase text-right">Total Price</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($mySales as $sale)
                                <tr class="hover:bg-gray-50/50 transition">
                                    <td class="p-4 font-bold text-blue-600 text-sm">#{{ $sale->id }}</td>
                                    <td class="p-4 text-gray-500 text-xs">{{ $sale->created_at->format('Y-m-d h:i A') }}</td>
                                    <td class="p-4">
                                        <div class="text-sm font-bold text-gray-800">{{ $sale->customer_name }}</div>
                                        <div class="text-gray-400 text-xs">{{ $sale->customer_phone }}</div>
                                    </td>
                                    <td class="p-4">
                                        <div class="text-sm font-bold text-gray-700">{{ $sale->laptop->brand ?? 'N/A' }}</div>
                                        <div class="text-xs text-gray-400">{{ $sale->laptop->model ?? 'N/A' }}</div>
                                    </td>
                                    <td class="p-4 text-center font-bold text-gray-700 text-sm">{{ $sale->quantity }}</td>
                                    <td class="p-4 text-right font-black text-gray-900 text-sm">Rs. {{ number_format($sale->total_price, 2) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="p-12 text-center text-gray-400 font-bold uppercase tracking-wider text-xs">
                                        You haven't made any sales yet.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                @if($mySales->hasPages())
                    <div class="p-4 border-t border-gray-50 bg-gray-50/50">
                        {{ $mySales->links() }}
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>

</body>
</html>