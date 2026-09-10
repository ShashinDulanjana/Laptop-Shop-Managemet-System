<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Laptop Inventory</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body class="bg-gray-100 min-h-screen font-sans antialiased">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    .custom-navbar {
        background-color: #1a202c !important; 
        padding: 12px 25px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: sticky;
        top: 0;
        z-index: 1060;
    }
    .brand-text {
        color: #3498db; 
        font-weight: bold;
        font-size: 1.5rem;
        text-decoration: none;
        text-transform: uppercase;
    }
    .logout-btn {
        background-color: #ff4d4d !important; 
        color: white !important;
        font-weight: bold;
        border-radius: 8px;
        padding: 8px 20px;
        border: none;
    }
    .hamburger-icon {
        color: white;
        font-size: 1.5rem;
        cursor: pointer;
        margin-right: 15px;
        user-select: none;
    }
    
    /* ස්ථාවර Full Height මෙනුව */
    .floating-menu {
        position: fixed;
        top: 60px; /* Navbar උස අනුව */
        left: 0;
        width: 280px;
        height: 100vh;
        background-color: #1a202c;
        box-shadow: 5px 0 15px rgba(0,0,0,0.3);
        z-index: 1050;
        transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        transform: translateX(-100%); /* ආරම්භයේදී වම් පස සැඟවී පවතී */
        visibility: hidden;
    }

    /* මෙනුව විවෘත වූ විට පෙන්වන ආකාරය */
    .floating-menu.show-menu {
        transform: translateX(0);
        visibility: visible;
    }

    .floating-menu .nav-link {
        color: #ddd;
        font-size: 1.1rem;
        padding: 15px 20px;
        display: block;
        text-decoration: none;
        transition: 0.3s;
    }
    .floating-menu .nav-link:hover {
        color: #3498db;
        background-color: rgba(255,255,255,0.1);
        padding-left: 30px;
    }
</style>

<nav class="custom-navbar">
    <div class="d-flex align-items-center">
        <span class="hamburger-icon" onclick="toggleMyMenu()">☰</span>
        <a href="#" class="brand-text">LAPTOP <span class="text-white">SHOP</span></a>
    </div>

    <div>
        <form method="POST" action="{{ route('logout') }}" class="m-0">
            @csrf
            <button type="submit" class="logout-btn" onclick="event.preventDefault(); this.closest('form').submit();">
                LOG OUT
            </button>
        </form>
    </div>
</nav>

<div class="floating-menu" id="sidebarMenu">
    <div class="py-3 mt-2">
        <ul class="nav flex-column">
            <li class="nav-item mb-2">
    <a href="{{ route('customer.shop') }}" class="nav-link">🏠 Shop Now</a>
</li>
            <li class="nav-item"><a href="{{ url('/dashboard') }}" class="nav-link">💻 Dashboard</a></li>
            
            {{-- Sales Assistant හට මෙනුවෙන් යාමට එකතු කළ ලින්ක් එක --}}
            @if(auth()->user()->role == 'sales_assistant')
                <li class="nav-item"><a href="{{ route('assistant.counter_sale') }}" class="nav-link">🛒 Counter Sale</a></li>
            @endif

            <li class="nav-item"><a href="/" class="nav-link">🏠 Home Page</a></li>
            <li class="nav-item"><a href="{{ route('contact') }}" class="nav-link">📞 Contact Us</a></li>
            <li class="nav-item"><a href="{{ route('about') }}" class="nav-link">ℹ️ About Us</a></li>
        </ul>
    </div>
</div>

<script>
    function toggleMyMenu() {
        var menu = document.getElementById("sidebarMenu");
        menu.classList.toggle("show-menu");
    }

    // පිටුවේ වෙනත් තැනක් ක්ලික් කළ විට මෙනුව වැසීමට (Optional)
    window.onclick = function(event) {
        if (!event.target.matches('.hamburger-icon')) {
            var menu = document.getElementById("sidebarMenu");
            if (menu.classList.contains('show-menu')) {
                menu.classList.remove('show-menu');
            }
        }
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>



    <div class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @php
                $lowStockLaptops = \App\Models\Laptop::where('stock', '<=', 3)->get();
            @endphp

            @if($lowStockLaptops->count() > 0)
                <div id="low-stock-alert" class="mb-6 mx-4 bg-red-50 border-l-4 border-red-500 p-4 rounded-2xl shadow-sm">
                    <div class="flex items-center gap-2 text-red-800 font-extrabold text-sm mb-2">
                        ⚠️ Attention: The following items are running low in stock!
                    </div>
                    <ul class="text-xs text-red-700 list-disc pl-5 space-y-1 font-semibold">
                        @foreach($lowStockLaptops as $lowLaptop)
                            <li>
                                <span class="text-slate-800 font-bold">{{ $lowLaptop->brand }} {{ $lowLaptop->model }}</span> 
                                has only <span class="bg-red-200 text-red-800 px-1.5 py-0.5 rounded font-black">{{ $lowLaptop->stock }}</span> left in inventory.
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="border-b border-gray-200 pb-3 mb-4 px-4">
                <h2 class="font-black text-3xl text-slate-800 tracking-tight flex items-center gap-2">
                    💻 Laptop Inventory
                </h2> 
            </div>

            <div class="flex flex-wrap items-center justify-end gap-3 mb-6 px-4">

                @if(auth()->user()->role == 'admin')
                    {{-- @if(auth()->user()->role == 'admin') --}}
                    <div class="flex items-center gap-3">
                        
                        <a href="{{ route('admin.sales.report') }}"
                           style="background-color: #3b82f6; color: white; font-weight: 800; padding: 12px 25px; border-radius: 12px; text-decoration: none; display: inline-flex; align-items: center; box-shadow: 0 10px 15px -3px rgba(59, 130, 246, 0.2); transition: 0.3s; text-transform: uppercase; font-size: 11px; letter-spacing: 1px;"
                           onmouseover="this.style.backgroundColor='#2563eb'; this.style.transform='translateY(-2px)'"
                           onmouseout="this.style.backgroundColor='#3b82f6'; this.style.transform='translateY(0px)'">
                             📊 Sales Report
                        </a>

                        <a href="{{ route('admin.users.create') }}"
                           style="background-color: #6366f1; color: white; font-weight: 800; padding: 12px 25px; border-radius: 12px; text-decoration: none; display: inline-flex; align-items: center; box-shadow: 0 10px 15px -3px rgba(99, 102, 241, 0.2); transition: 0.3s; text-transform: uppercase; font-size: 11px; letter-spacing: 1px;"
                           onmouseover="this.style.backgroundColor='#4f46e5'; this.style.transform='translateY(-2px)'"
                           onmouseout="this.style.backgroundColor='#6366f1'; this.style.transform='translateY(0px)'">
                             👤 Add Staff Account
                        </a>

                        <a href="{{ route('admin.users.index') }}"
                           style="background-color: #f59e0b; color: white; font-weight: 800; padding: 12px 25px; border-radius: 12px; text-decoration: none; display: inline-flex; align-items: center; box-shadow: 0 10px 15px -3px rgba(245, 158, 11, 0.2); transition: 0.3s; text-transform: uppercase; font-size: 11px; letter-spacing: 1px;"
                           onmouseover="this.style.backgroundColor='#d97706'; this.style.transform='translateY(-2px)'"
                           onmouseout="this.style.backgroundColor='#f59e0b'; this.style.transform='translateY(0px)'">
                             👥 Manage Users
                        </a>

                        <a href="{{ route('admin.online.orders') }}"
                           style="background-color: #a855f7; color: white; font-weight: 800; padding: 12px 25px; border-radius: 12px; text-decoration: none; display: inline-flex; align-items: center; box-shadow: 0 10px 15px -3px rgba(168, 85, 247, 0.2); transition: 0.3s; text-transform: uppercase; font-size: 11px; letter-spacing: 1px;"
                           onmouseover="this.style.backgroundColor='#9333ea'; this.style.transform='translateY(-2px)'"
                           onmouseout="this.style.backgroundColor='#a855f7'; this.style.transform='translateY(0px)'">
                             🌐 Online Orders

                        <a href="{{ route('laptops.create') }}"
                           style="background-color: #10b981; color: white; font-weight: 800; padding: 12px 25px; border-radius: 12px; text-decoration: none; display: inline-flex; align-items: center; box-shadow: 0 10px 15px -3px rgba(16, 185, 129, 0.2); transition: 0.3s; text-transform: uppercase; font-size: 11px; letter-spacing: 1px;"
                           onmouseover="this.style.backgroundColor='#059669'; this.style.transform='translateY(-2px)'"
                           onmouseout="this.style.backgroundColor='#10b981'; this.style.transform='translateY(0px)'">
                              + Add New Laptop
                        </a>

                    </div>
                @endif

                {{-- Sales Assistant හට Dashboard එක උඩින්ම පෙනෙන බටන් එක --}}
                @if(auth()->user()->role == 'sales_assistant')
                    <a href="{{ route('assistant.counter_sale') }}"
                       style="background-color: #3b82f6; color: white; font-weight: 800; padding: 12px 25px; border-radius: 12px; text-decoration: none; display: inline-flex; align-items: center; box-shadow: 0 10px 15px -3px rgba(59, 130, 246, 0.2); transition: 0.3s; text-transform: uppercase; font-size: 11px; letter-spacing: 1px;"
                       onmouseover="this.style.backgroundColor='#2563eb'; this.style.transform='translateY(-2px)'"
                       onmouseout="this.style.backgroundColor='#3b82f6'; this.style.transform='translateY(0px)'">
                          🛒 Create Counter Sale
                    </a>
                @endif

                {{-- Sales Assistant හට මෙනුවෙන් යාමට එකතු කළ ලින්ක් එක --}}
                @if(auth()->user()->role == 'sales_assistant')
                    <a href="{{ route('assistant.my_sales') }}" 
                       style="background-color: #3b82f6; color: white; font-weight: 800; padding: 12px 25px; border-radius: 12px; text-decoration: none; display: inline-flex; align-items: center; box-shadow: 0 10px 15px -3px rgba(59, 130, 246, 0.2); transition: 0.3s; text-transform: uppercase; font-size: 11px; letter-spacing: 1px;"
                       onmouseover="this.style.backgroundColor='#2563eb'; this.style.transform='translateY(-2px)'"
                       onmouseout="this.style.backgroundColor='#3b82f6'; this.style.transform='translateY(0px)'">
                          📊 My Sales History
                    </a>
                @endif

            </div>



            <div class="mb-12 px-4">

                <form action="{{ route('dashboard') }}" method="GET" class="flex flex-col gap-4">

                    

                    <div>

                        <select name="sort" onchange="this.form.submit()"

                                style="background-color: white; border: 1px solid #e2e8f0; padding: 10px 15px; border-radius: 15px; font-size: 13px; outline: none; color: #334155; cursor: pointer;">

                            <option value="">Sort By (Default)</option>

                            <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>

                            <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>

                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First</option>

                        </select>

                    </div>



                    <div class="flex gap-3">

                        <input type="text" name="search" id="laptopSearchInput" value="{{ request('search') }}" autocomplete="off" list="laptop-suggestions" oninput="checkEmptySearch(this)"
                               placeholder="Search by Brand or Model (e.g. HP, Victus)..."
                               style="flex: 1; background-color: white; border: 1px solid #e2e8f0; padding: 14px 25px; border-radius: 15px; font-size: 14px; outline: none; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); color: #334155;">

                        
                        <datalist id="laptop-suggestions">
                            @foreach($laptops as $l)
                                <option value="{{ $l->brand }}">
                                <option value="{{ $l->model }}">
                                <option value="{{ $l->brand }} {{ $l->model }}">
                            @endforeach
                        </datalist>


                        <button type="submit"

                                style="background-color: #3b82f6; color: white; font-weight: 800; padding: 0 30px; border-radius: 15px; border: none; cursor: pointer; transition: 0.3s; text-transform: uppercase; font-size: 11px; letter-spacing: 1px;">

                            Search

                        </button>



                        @if(request('search'))

                            <a href="{{ route('dashboard') }}"

                               style="background-color: #ef4444; color: white; font-weight: 800; padding: 14px 20px; border-radius: 15px; text-decoration: none; font-size: 11px; text-transform: uppercase; display: flex; align-items: center; letter-spacing: 1px;">

                                  Clear

                            </a>

                        @endif

                    </div>

                </form>

            </div>



            @if(session('success'))

                <div id="alert-box" style="background-color: #d1fae5; border-left: 5px solid #10b981; color: #065f46; padding: 15px; border-radius: 12px; margin-bottom: 25px; font-weight: bold; display: flex; justify-content: space-between; align-items: center; margin-left: 15px; margin-right: 15px;">

                    <span>✅ {{ session('success') }}</span>

                    <button onclick="document.getElementById('alert-box').style.display='none'" style="background: none; border: none; font-size: 20px; cursor: pointer;">&times;</button>

                </div>

            @endif



            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10 px-4">

                @forelse($laptops as $laptop)

                <div class="bg-white rounded-3xl overflow-hidden shadow-sm border border-gray-100">

                    <div class="h-64 w-full bg-white flex items-center justify-center overflow-hidden p-4">

                        @if($laptop->image)

                            <img src="{{ asset('images/' . $laptop->image) }}" class="max-h-full max-w-full object-contain">

                        @else

                            <div class="text-gray-300 font-bold uppercase tracking-widest text-xs">No Image</div>

                        @endif

                    </div>



                    <div class="p-6">

                        <div class="mb-4">

                            <h3 class="text-lg font-bold text-gray-900">{{ $laptop->brand }}</h3>

                            <p class="text-gray-500 text-sm">{{ $laptop->model }}</p>

                            

                            <p class="text-gray-500 text-[11px] mt-2 italic leading-relaxed">

                                {{ $laptop->specifications }}

                            </p>

                        </div>

                        

                        <div class="flex justify-between items-center mb-6 pt-4 border-t border-gray-50">

                            <span class="text-lg font-medium text-gray-900">

                                <span class="text-sm">Rs.</span> {{ number_format($laptop->price, 2) }}

                            </span>

                            
                            @if(auth()->user()->role == 'admin')
                                @if($laptop->stock <= 3)
                                    <span class="bg-red-100 text-red-600 text-[10px] font-black px-2 py-1 rounded uppercase animate-pulse">
                                        ⚠️ Low Stock: {{ $laptop->stock }}
                                    </span>
                                @else
                                    <span class="bg-gray-100 text-gray-600 text-[10px] font-bold px-2 py-1 rounded uppercase">
                                        Stock: {{ $laptop->stock }}
                                    </span>
                                @endif
                            @else
                                {{-- මෙතන වෙනස් කළා: ස්ටොක් එක 0 ට වඩා වැඩි නම් විතරක් Available පෙන්වනවා, නැත්නම් Unavailable පෙන්වනවා --}}
                                @if($laptop->stock > 0)
                                    <span class="bg-emerald-100 text-emerald-800 text-[10px] font-extrabold px-2.5 py-1 rounded-full uppercase tracking-wider flex items-center gap-1">
                                        🟢 Available
                                    </span>
                                @else
                                    <span class="bg-red-100 text-red-800 text-[10px] font-extrabold px-2.5 py-1 rounded-full uppercase tracking-wider flex items-center gap-1">
                                        🔴 Unavailable
                                    </span>
                                @endif
                            @endif

                        </div>



                        @if(auth()->user()->role == 'admin')
                            <div class="flex gap-4">

                                <a href="{{ route('laptops.edit', $laptop->id) }}"
                                   style="flex: 1; background-color: #3b82f6; color: white; text-align: center; padding: 12px 0; border-radius: 12px; font-weight: 800; text-decoration: none; text-transform: uppercase; font-size: 11px; transition: 0.3s;"
                                   onmouseover="this.style.backgroundColor='#2563eb'"
                                   onmouseout="this.style.backgroundColor='#3b82f6'">
                                     Edit Details
                                </a>

                                <form action="{{ route('laptops.destroy', $laptop->id) }}" method="POST" class="delete-form" style="flex: 1;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="delete-btn"
                                            style="width: 100%; background-color: #ef4444; color: white; padding: 12px 0; border-radius: 12px; font-weight: 800; border: none; cursor: pointer; text-transform: uppercase; font-size: 11px; transition: 0.3s;"
                                            onmouseover="this.style.backgroundColor='#dc2626'"
                                            onmouseout="this.style.backgroundColor='#ef4444'">
                                        Delete
                                    </button>
                                </form>

                            </div>
                        @endif


                        @if(auth()->user()->role == 'sales_assistant')
                            @if($laptop->stock <= 3)
                                <div class="w-full bg-red-50 text-red-700 text-center py-3 rounded-xl font-extrabold text-[11px] uppercase tracking-wider border border-red-200 animate-pulse">
                                    ⚠️ Low Stock Warning (Stock: {{ $laptop->stock }})
                                </div>
                            @else
                                <div class="w-full bg-emerald-50 text-emerald-700 text-center py-3 rounded-xl font-extrabold text-[11px] uppercase tracking-wider border border-emerald-200">
                                    ✓ Sales Mode Active (Stock: {{ $laptop->stock }})
                                </div>
                            @endif
                        @endif

                    </div>

                </div>

                @empty

                    <div class="col-span-full text-center py-20 bg-white rounded-3xl border-2 border-dashed border-gray-200">

                        <p class="text-gray-400 font-bold uppercase tracking-widest text-sm">Inventory is empty</p>

                    </div>

                @endforelse



                <div class="mt-12 px-4 pb-12 ">

    {{ $laptops->links() }}

</div>

            </div>

        </div>

    </div>



    <script>
        // Auto hide low stock alert smoothly after 5 seconds
        setTimeout(function() {
            var lowStockAlert = document.getElementById('low-stock-alert');
            if (lowStockAlert) {
                lowStockAlert.style.transition = "opacity 0.8s ease-out";
                lowStockAlert.style.opacity = "0";
                setTimeout(function() {
                    lowStockAlert.remove();
                }, 800);
            }
        }, 5000);

        // Auto refresh back to dashboard if search input is cleared manually via backspace
        function checkEmptySearch(input) {
            if (input.value.trim() === '') {
                window.location.href = "{{ route('dashboard') }}";
            }
        }

        document.querySelectorAll('.delete-btn').forEach(button => {

            button.addEventListener('click', function() {

                const form = this.closest('.delete-form');

                
                Swal.fire({

                    title: "Are you sure?",

                    text: "You won't be able to revert this!",

                    icon: "warning",

                    showCancelButton: true,

                    confirmButtonColor: "#ef4444",

                    cancelButtonColor: "#64748b",  

                    confirmButtonText: "Yes, delete it!",

                    cancelButtonText: "No, cancel",

                    borderRadius: "15px"

                }).then((result) => {

                    if (result.isConfirmed) {

                        form.submit();

                    }

                });

            });

        });

    </script>

</body>

</html>