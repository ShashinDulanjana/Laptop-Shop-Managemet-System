<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Orders Dashboard - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
</head>
<body class="bg-gray-100 min-h-screen font-sans antialiased">

    <!-- Matching App Sticky Navbar Layout -->
    <nav class="bg-[#1a202c] px-6 py-3 flex justify-between items-center sticky top-0 z-50 shadow-md">
        <a href="#" class="text-[#3498db] font-bold text-xl uppercase tracking-wider">LAPTOP <span class="text-white">SHOP</span></a>
        <a href="{{ url('/dashboard') }}" class="bg-slate-700 hover:bg-slate-600 text-white font-bold text-xs py-2.5 px-4 rounded-xl tracking-wide uppercase transition shadow-sm">
            ← Back to Dashboard
        </a>
    </nav>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-4">
            
            <!-- Page Header Identity Header Description -->
            <div class="border-b border-gray-200 pb-3 mb-6">
                <h2 class="font-black text-3xl text-slate-800 tracking-tight flex items-center gap-2">
                    🌐 Direct Online Web Orders
                </h2> 
                <p class="text-xs font-semibold text-gray-400 mt-1 uppercase tracking-wider">Exclusive monitoring deck for customer portal transactions</p>
            </div>

            <!-- Analytics Financial Grid Cards Summary Component -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                
                <!-- 💰 Card 1: Total Online Revenue Monitor -->
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-black text-gray-400 uppercase tracking-wider mb-1">Total Online Revenue</p>
                        <h3 class="text-3xl font-black text-purple-600">Rs. {{ number_format($totalOnlineRevenue, 2) }}</h3>
                    </div>
                    <div class="bg-purple-50 p-4 rounded-2xl text-2xl text-purple-500 font-bold">💰</div>
                </div>

                <!-- 📦 Card 2: Total Completed Web Placements Count -->
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-black text-gray-400 uppercase tracking-wider mb-1">Total Online Placements</p>
                        <h3 class="text-3xl font-black text-slate-800">{{ $onlineOrders->count() }} Orders</h3>
                    </div>
                    <div class="bg-blue-50 p-4 rounded-2xl text-2xl text-blue-500 font-bold">📦</div>
                </div>

            </div>

            <!-- Main Log Data Table Interface Layout Wrapper -->
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="bg-slate-50 border-b border-gray-100 text-slate-500 uppercase font-black tracking-wider">
                                <th class="p-4">Order ID</th>
                                <th class="p-4">Customer</th>
                                <th class="p-4">Contact Details</th>
                                <th class="p-4">Laptop Purchased</th>
                                <th class="p-4 text-center">Qty</th>
                                <th class="p-4">Payment</th>
                                <th class="p-4 text-right">Total Paid Amount</th>
                                <th class="p-4 text-center">Status</th>
                                <th class="p-4">Date & Time</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 text-slate-600 font-semibold">
                            @forelse($onlineOrders as $order)
                                <tr class="hover:bg-slate-50/80 transition-colors">
                                    <td class="p-4 text-slate-900 font-black">#ORD-00{{ $order->id }}</td>
                                    <td class="p-4 text-slate-900 font-bold">{{ $order->name }}</td>
                                    <td class="p-4">
                                        <p>{{ $order->phone }}</p>
                                        <p class="text-[10px] text-gray-400 font-medium lowercase">{{ $order->email ?? 'no-email@store.com' }}</p>
                                    </td>
                                    <td class="p-4">
                                        <span class="text-slate-900 font-bold block">{{ $order->laptop->brand ?? 'Unknown Brand' }}</span>
                                        <span class="text-gray-400 text-[10px] font-medium">{{ $order->laptop->model ?? 'Model Info' }}</span>
                                    </td>
                                    <td class="p-4 text-center text-slate-900 font-bold">{{ $order->quantity }}</td>
                                    <td class="p-4">
                                        <span class="bg-slate-100 text-slate-700 text-[10px] px-2 py-0.5 rounded font-black tracking-wide uppercase">{{ $order->payment_method }}</span>
                                    </td>
                                    <td class="p-4 text-right text-blue-600 font-extrabold text-sm">
                                        Rs. {{ number_format(($order->laptop->price ?? 0) * $order->quantity, 2) }}
                                    </td>
                                    <td class="p-4 text-center">
                                        <!-- DYNAMIC AUTO-SUBMIT STATUS DROPDOWN FORM -->
                                        <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <select name="status" onchange="this.form.submit()" 
                                                class="text-[10px] font-black uppercase rounded-full px-2 py-1 border cursor-pointer focus:outline-none transition-colors
                                                {{ strtoupper($order->status ?? 'PENDING') == 'PENDING' ? 'bg-amber-100 text-amber-700 border-amber-300' : '' }}
                                                {{ strtoupper($order->status ?? '') == 'APPROVED' ? 'bg-blue-100 text-blue-700 border-blue-300' : '' }}
                                                {{ strtoupper($order->status ?? '') == 'DELIVERED' ? 'bg-green-100 text-green-700 border-green-300' : '' }}
                                                {{ strtoupper($order->status ?? '') == 'CANCELLED' ? 'bg-red-100 text-red-700 border-red-300' : '' }}">
                                                
                                                <option value="PENDING" {{ strtoupper($order->status ?? 'PENDING') == 'PENDING' ? 'selected' : '' }}>Pending</option>
                                                <option value="APPROVED" {{ strtoupper($order->status ?? '') == 'APPROVED' ? 'selected' : '' }}>Approved</option>
                                                <option value="DELIVERED" {{ strtoupper($order->status ?? '') == 'DELIVERED' ? 'selected' : '' }}>Delivered</option>
                                                <option value="CANCELLED" {{ strtoupper($order->status ?? '') == 'CANCELLED' ? 'selected' : '' }}>Cancelled</option>
                                            </select>
                                        </form>
                                    </td>
                                    <td class="p-4 text-gray-400 text-[10px] font-medium">
                                        {{ $order->created_at ? $order->created_at->format('Y-m-d h:i A') : date('Y-m-d h:i A') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center py-12 text-gray-400 font-bold uppercase tracking-widest text-xs bg-gray-50/50">
                                        No online web orders recorded yet.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

</body>
</html>