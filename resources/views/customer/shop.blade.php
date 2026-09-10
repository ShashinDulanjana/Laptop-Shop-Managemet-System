<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laptop Shop - Customer View</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body { background-color: #f4f6f9; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        
        /* Navbar Styling */
        .custom-navbar {
            background-color: #1a202c !important; 
            padding: 15px 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 1060;
        }
        .brand-text { color: #3498db; font-weight: 800; font-size: 1.5rem; text-decoration: none; text-transform: uppercase; letter-spacing: 1px; }
        .hamburger-icon { color: white; font-size: 1.8rem; cursor: pointer; margin-right: 20px; transition: 0.3s; }
        .hamburger-icon:hover { color: #3498db; }
        
        /* Sidebar Styling */
        .floating-menu {
            position: fixed; top: 68px; left: 0; width: 260px; height: 100vh;
            background-color: #1a202c; box-shadow: 4px 0 10px rgba(0,0,0,0.1);
            z-index: 1050; transition: transform 0.4s ease;
            transform: translateX(-100%); visibility: hidden;
        }
        .floating-menu.show-menu { transform: translateX(0); visibility: visible; }
        .floating-menu .nav-link { color: #a0aec0; padding: 15px 25px; display: block; text-decoration: none; font-weight: 500; font-size: 1.1rem; border-left: 4px solid transparent; transition: 0.3s; }
        .floating-menu .nav-link:hover, .floating-menu .nav-link.active { color: #ffffff; background: rgba(255,255,255,0.05); border-left-color: #3498db; }

        /* Card & UI Styling */
        .page-title { color: #2d3748; font-weight: 800; display: flex; align-items: center; gap: 10px; }
        .search-container { background: white; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.02); padding: 20px; }
        
        .laptop-card {
            border: none; border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            transition: all 0.3s ease; background: white; padding: 25px;
        }
        .laptop-card:hover { transform: translateY(-5px); box-shadow: 0 10px 25px rgba(0,0,0,0.1); }
        .price-tag { color: #2b6cb0; font-weight: 800; font-size: 1.4rem; }
        
        /* Hero Animations */
        .animate-fade-in { animation: fadeIn 2s ease-in-out; }
        .animate-drop-down { animation: dropDown 1s ease-out; }

        @keyframes fadeIn { 0% { opacity: 0; } 100% { opacity: 1; } }
        @keyframes dropDown { 0% { transform: translateY(-50px); opacity: 0; } 100% { transform: translateY(0); opacity: 1; } }
    </style>
</head>
<body>

<nav class="custom-navbar shadow-sm">
    <div class="d-flex align-items-center">
        <span class="hamburger-icon" onclick="toggleMyMenu()">☰</span>
        <a href="#" class="brand-text">LAPTOP <span class="text-white">SHOP</span></a>
    </div>
    
    <div class="d-flex align-items-center gap-4">
        <a href="#" class="position-relative text-white me-2 d-flex align-items-center justify-content-center" data-bs-toggle="offcanvas" data-bs-target="#cartSidebar" style="text-decoration: none; transition: color 0.2s;" onmouseover="this.style.color='#3498db'" onmouseout="this.style.color='white'">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" class="bi bi-cart3" viewBox="0 0 16 16">
                <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .49.598l-1 5a.5.5 0 0 1-.465.401l-9.397.472L4.415 11H13a.5.5 0 0 1 0 1H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l.84 4.479 9.144-.459L13.89 4zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
            </svg>
            <span id="cart-badge-count" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-success" style="font-size: 0.7rem; padding: 4px 6px;">
                {{ session('cart') ? count(session('cart')) : 0 }}
            </span>
        </a>

        <a href="{{ url('/dashboard') }}" class="btn btn-danger fw-bold px-4" style="border-radius: 8px;">LOG IN</a>
    </div>
</nav>

<div class="offcanvas offcanvas-end text-white" tabindex="-1" id="cartSidebar" aria-labelledby="cartSidebarLabel" style="background-color: #1a202c; z-index: 1070; border-left: 2px solid #3498db;">
    <div class="offcanvas-header" style="border-bottom: 1px solid #2d3748; padding: 20px;">
        <h5 class="offcanvas-title fw-bold flex items-center gap-2" id="cartSidebarLabel">🛒 Your Shopping Cart</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body d-flex flex-column justify-content-between p-4">
        
        <div id="cart-dynamic-items" class="flex-grow-1 overflow-auto mb-3">
            @if(session('cart') && count(session('cart')) > 0)
                @foreach(session('cart') as $id => $item)
                    <div class="d-flex align-items-center justify-content-between mb-3 pb-3 border-bottom border-secondary">
                        <div class="d-flex align-items-center gap-3 w-100">
                            @if($item['image'])
                                <img src="{{ $item['image'] }}" style="width: 55px; height: 55px; object-fit: contain; border-radius: 5px; background: white; padding: 2px;">
                            @else
                                <div class="bg-secondary text-center text-white rounded d-flex align-items-center justify-content-center" style="width: 55px; height: 55px; font-size: 0.6rem;">No Img</div>
                            @endif
                            <div class="flex-grow-1">
                                <h6 class="mb-0 text-info small fw-bold text-uppercase">{{ $item['brand'] }}</h6>
                                <p class="text-white small mb-1 fw-semibold">{{ $item['model'] }}</p>
                                <span class="text-success small fw-bold">Rs. {{ number_format($item['price'], 0) }} x {{ $item['quantity'] }}</span>
                            </div>
                            <button type="button" class="btn btn-sm btn-link text-danger p-0 remove-from-cart-trigger" data-id="{{ $id }}" title="Remove item">
                                🗑️
                            </button>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="text-center py-5">
                    <p class="text-muted fs-5">Your cart is currently empty.</p>
                    <p class="small text-secondary">Add premium laptops to power your productivity!</p>
                </div>
            @endif
        </div>
        
        <div class="pt-3" style="border-top: 1px solid #2d3748;">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="fw-bold text-light fs-5">Subtotal:</span>
                <span id="cart-dynamic-subtotal" class="fw-bold text-info fs-4">
                    Rs. 
                    @php 
                        $subtotal = 0;
                        if(session('cart')) {
                            foreach(session('cart') as $item) { $subtotal += $item['price'] * $item['quantity']; }
                        }
                        echo number_format($subtotal, 0);
                    @endphp
                </span>
            </div>
            <a href="{{ route('cart.checkout') }}" class="btn btn-success w-100 fw-bold py-2 shadow-sm text-uppercase tracking-wider" style="border-radius: 8px;">
                Proceed To Checkout ➔
            </a>
        </div>
    </div>
</div>

<div class="floating-menu" id="sidebarMenu">
    <div class="py-4">
        <ul class="nav flex-column gap-2">
            <li class="nav-item"><a href="{{ route('customer.shop') }}" class="nav-link active">🛒 Shop Now</a></li>
            <li class="nav-item"><a href="{{ url('/dashboard') }}" class="nav-link">💻 Dashboard</a></li>
            <li class="nav-item"><a href="{{ route('about') }}" class="nav-link">ℹ️ About Us</a></li>
            <li class="nav-item"><a href="{{ route('contact') }}" class="nav-link">📞 Contact Us</a></li>
            <li class="nav-item"><a href="/" class="nav-link">🏠 Home Page</a></li>
        </ul>
    </div>
</div>

<div class="container-fluid bg-dark text-white py-5 animate-fade-in" style="background: url('{{ asset('images/laptop_hero.png') }}') no-repeat center center; background-size: cover;">
    <div class="container py-5 text-center animate-drop-down">
        <h1 class="display-3 fw-bold mb-4">Power Your Productivity</h1>
        <p class="lead mb-5">Discover the finest selection of premium high-performance laptops at LAPTOP SHOP.</p>
        <a href="#searchForm" class="btn btn-primary btn-lg rounded-pill px-5 fw-bold text-uppercase">Explore Inventory ↓</a>
    </div>
</div>

<div class="container py-5">
    <div class="row mb-4 align-items-center">
        <div class="col-md-6">
            <h2 class="page-title mb-0">💻 Choose Your Laptop</h2>
        </div>
    </div>

    <div class="search-container mb-5">
        <form action="{{ route('customer.shop') }}" method="GET" class="row align-items-center" id="searchForm">
            <div class="col-md-3 mb-3 mb-md-0">
                <select id="sortDropdown" name="sort" class="form-select border-0 bg-light" style="padding: 12px; border-radius: 8px;" onchange="this.form.submit()">
                    <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Default (Oldest First)</option>
                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First</option>
                    <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                </select>
            </div>
            <div class="col-md-9">
                <div class="input-group">
                    <input type="text" id="searchInput" name="search" class="form-control border-0 bg-light" placeholder="Search by Brand or Model (e.g. HP, Victus)..." value="{{ request('search') }}" style="padding: 12px; border-radius: 8px 0 0 8px;" oninput="checkSearch(this)">
                    <button class="btn btn-primary px-4 fw-bold" type="submit" style="border-radius: 0 8px 8px 0;">SEARCH</button>
                </div>
            </div>
        </form>
    </div>

    <div class="row">
        @forelse($laptops as $laptop)
        <div class="col-lg-4 col-md-6 mb-5">
            <div class="laptop-card h-100 d-flex flex-column text-center">
                <div class="mb-4" style="height: 200px; display: flex; align-items: center; justify-content: center;">
                    @if($laptop->image)
                        <img src="{{ asset('images/' . $laptop->image) }}" class="img-fluid" style="max-height: 100%; object-fit: contain;" alt="{{ $laptop->brand }} {{ $laptop->model }}">
                    @else
                        <div class="bg-light w-100 h-100 d-flex align-items-center justify-content-center" style="border-radius: 10px;">
                            <span class="text-muted">No Image Available</span>
                        </div>
                    @endif
                </div>
                
                <h5 class="fw-bold text-uppercase mb-2">{{ $laptop->brand }}</h5>
                <p class="text-muted small mb-3 flex-grow-1">{{ $laptop->model }}</p>
                
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="price-tag mb-0">Rs. {{ number_format($laptop->price, 0) }}</div>
                    <!-- FIXED: Force stock output to display 0 if it is negative -->
                    <span class="badge {{ $laptop->stock <= 0 ? 'bg-danger text-white' : 'bg-light text-dark' }} border fw-bold px-2 py-1" style="border-radius: 5px; font-size: 0.8rem; {{ $laptop->stock <= 0 ? '' : 'background-color: #f8f9fa !important;' }}">
                        STOCK: {{ $laptop->stock <= 0 ? 0 : $laptop->stock }}
                    </span>
                </div>

                <div class="mt-auto">
                    <div class="row g-2 mb-2">
                        <!-- FIXED: Disable checkout entirely if stock is less than or equal to 0 -->
                        @if($laptop->stock <= 0)
                            <div class="col-12">
                                <button type="button" class="btn btn-secondary fw-bold w-100 py-2 text-uppercase" style="border-radius: 8px; font-size: 0.85rem;" disabled>
                                    ❌ Out of Stock
                                </button>
                            </div>
                        @else
                            <div class="col-6">
                                <button type="button" 
                                        class="btn btn-outline-primary fw-bold w-100 py-2 d-flex align-items-center justify-content-center gap-1 add-to-cart-trigger" 
                                        style="border-radius: 8px; font-size: 0.85rem;"
                                        data-id="{{ $laptop->id }}" 
                                        data-brand="{{ $laptop->brand }}"
                                        data-model="{{ $laptop->model }}"
                                        data-price="{{ $laptop->price }}"
                                        data-stock="{{ $laptop->stock }}"
                                        data-image="{{ $laptop->image ? asset('images/' . $laptop->image) : '' }}">
                                    📂 Cart
                                </button>
                            </div>
                            <div class="col-6">
                                <a href="{{ route('laptop.checkout', $laptop->id) }}" class="btn btn-success fw-bold w-100 py-2 d-flex align-items-center justify-content-center gap-1" style="border-radius: 8px; font-size: 0.85rem;">
                                    ⚡ BUY NOW
                                </a>
                            </div>
                        @endif
                    </div>
                    <a href="{{ route('laptop.show', $laptop->id) }}" class="btn btn-light btn-sm text-secondary w-100 py-2" style="border-radius: 8px;">View Details</a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <h4 class="text-muted">No laptops found matching your search.</h4>
            <a href="{{ route('customer.shop') }}" class="btn btn-outline-primary mt-3">Clear Search</a>
        </div>
        @endforelse
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $laptops->appends(request()->query())->links('pagination::bootstrap-5') }}
    </div>
</div>

<footer class="text-center text-white py-4" style="background-color: #1a202c; border-top: 2px solid #3498db;">
    <p class="mb-1 fw-bold">&copy; 2026 LAPTOP SHOP. All Rights Reserved.</p>
</footer>

<script>
    // FIXED: Initialize server-side session cart state into frontend memory safely
    window.currentCart = @json(session('cart') ?? (object)[]);

    function toggleMyMenu() {
        var menu = document.getElementById("sidebarMenu");
        menu.classList.toggle("show-menu");
    }

    function checkSearch(input) {
        if (input.value === "") { window.location.href = "{{ route('customer.shop') }}"; }
    }

    // Common function to helper re-render cart elements
    function renderCartContents(data) {
        // FIXED: Sync cache to match server state updates dynamically
        window.currentCart = data.cart || {};
        
        document.getElementById('cart-badge-count').innerText = data.cartCount;
        let container = document.getElementById('cart-dynamic-items');
        container.innerHTML = ''; 

        if (Object.keys(data.cart).length === 0) {
            container.innerHTML = `
                <div class="text-center py-5">
                    <p class="text-muted fs-5">Your cart is currently empty.</p>
                    <p class="small text-secondary">Add premium laptops to power your productivity!</p>
                </div>`;
        } else {
            Object.keys(data.cart).forEach(key => {
                let item = data.cart[key];
                let imgElement = item.image ? 
                    `<img src="${item.image}" style="width: 55px; height: 55px; object-fit: contain; border-radius: 5px; background: white; padding: 2px;">` :
                    `<div class="bg-secondary text-center text-white rounded d-flex align-items-center justify-content-center" style="width: 55px; height: 55px; font-size: 0.6rem;">No Img</div>`;

                container.innerHTML += `
                    <div class="d-flex align-items-center justify-content-between mb-3 pb-3 border-bottom border-secondary">
                        <div class="d-flex align-items-center gap-3 w-100">
                            ${imgElement}
                            <div class="flex-grow-1">
                                <h6 class="mb-0 text-info small fw-bold text-uppercase">${item.brand}</h6>
                                <p class="text-white small mb-1 fw-semibold">${item.model}</p>
                                <span class="text-success small fw-bold">Rs. ${Number(item.price).toLocaleString()} x ${item.quantity}</span>
                            </div>
                            <button type="button" class="btn btn-sm btn-link text-danger p-0 remove-from-cart-trigger" data-id="${key}" title="Remove item">
                                🗑️
                            </button>
                        </div>
                    </div>`;
            });
        }
        document.getElementById('cart-dynamic-subtotal').innerText = 'Rs. ' + data.total;
    }

    // 🚀 ADD TO CART DYNAMIC AJAX
    document.querySelectorAll('.add-to-cart-trigger').forEach(button => {
        button.addEventListener('click', function() {
            let id = this.getAttribute('data-id');
            let brand = this.getAttribute('data-brand');
            let model = this.getAttribute('data-model');
            let price = this.getAttribute('data-price');
            let image = this.getAttribute('data-image');
            
            // FIXED: Fetch max inventory constraint from HTML
            let maxStock = parseInt(this.getAttribute('data-stock')) || 0;
            let currentQtyInCart = 0;
            
            if (window.currentCart && window.currentCart[id]) {
                currentQtyInCart = parseInt(window.currentCart[id].quantity) || 0;
            }

            // FIXED: Intercept action right here and throw the critical examiner warning alert!
            if (currentQtyInCart >= maxStock) {
                alert(`⚠️ Warning: Only ${maxStock} items are available in stock. You cannot add more than the available quantity!`);
                return; // Stop execution safely
            }

            let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch(`/cart/add/${id}`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': token },
                body: JSON.stringify({ brand: brand, model: model, price: price, image: image })
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    renderCartContents(data);
                    let sidebar = document.getElementById('cartSidebar');
                    let bsOffcanvas = bootstrap.Offcanvas.getOrCreateInstance(sidebar);
                    bsOffcanvas.show();
                }
            })
            .catch(error => console.error('Error handling AJAX add processing:', error));
        });
    });

    // 🗑️ BULLETPROOF DYNAMIC EVENT DELEGATION FOR DELETE ACTION (FIXED)
    document.getElementById('cart-dynamic-items').addEventListener('click', function(e) {
        // Looks for the exact button element or its closest target boundary confidently
        let deleteBtn = e.target.closest('.remove-from-cart-trigger');
        
        if(deleteBtn) {
            let id = deleteBtn.getAttribute('data-id');
            let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch(`/cart/remove/${id}`, {
                method: 'POST',
                headers: { 
                    'Content-Type': 'application/json', 
                    'X-CSRF-TOKEN': token 
                }
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) { 
                    renderCartContents(data); 
                }
            })
            .catch(error => console.error('Error handling AJAX delete processing:', error));
        }
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>