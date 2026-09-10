<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Counter Sale - Sales Assistant</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-dark px-4 py-3 shadow-sm">
    <span class="navbar-brand mb-0 h1 fw-bold text-info">💻 SALES ASSISTANT PANEL</span>
    <a href="{{ route('dashboard') }}" class="inline-block px-4 py-1.5 border border-gray-500 text-white text-sm font-medium rounded hover:bg-gray-700 hover:border-gray-400 transition duration-200">
    ← Back to Dashboard
</a>
</nav>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow border-0 rounded-3">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="card-title mb-0 fw-bold">🛒 New Walk-in / Counter Sale</h5>
                </div>
                <div class="card-body p-4">

                    @if(session('success'))
                        <div class="alert alert-success border-0 shadow-sm mb-4">
                            🎉 <strong>Success!</strong> {{ session('success') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger border-0 shadow-sm mb-4">
                            ⚠️ {{ $errors->first() }}
                        </div>
                    @endif

                    <form action="{{ route('assistant.counter_sale.store') }}" method="POST">
                        @csrf
                        
                        <h6 class="text-secondary fw-bold mb-3">👤 Customer Information</h6>
                        <div class="row g-3 mb-4">
    <div class="col-md-6">
        <label class="form-label">Customer Name</label>
        <input type="text" name="customer_name" class="form-control" placeholder="John Doe" required
               oninput="this.value = this.value.replace(/[^a-zA-Z\s.]/g, '')">
    </div>
                            <div class="col-md-6">
                                <label class="form-label">Phone Number</label>
                                <input type="text" name="customer_phone" class="form-control" placeholder="07XXXXXXXX" maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
                            </div>
                        </div>

                        <h6 class="text-secondary fw-bold mb-3">📦 Product & Quantity</h6>
                        <div class="row g-3 mb-4">
                            <div class="col-md-12">
                                <label class="form-label">Select Laptop Model</label>
                                <select name="laptop_id" id="laptopSelect" class="form-select" required onchange="updateLaptopDetails()">
                                    <option value="" selected disabled>-- Choose a Laptop --</option>
                                    @foreach($laptops as $laptop)
                                        <option value="{{ $laptop->id }}" data-price="{{ $laptop->price }}" data-stock="{{ $laptop->stock }}">
                                            {{ $laptop->brand }} {{ $laptop->model }} (Rs. {{ number_format($laptop->price, 0) }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="col-md-6 mt-3">
                                <div class="p-3 bg-white border rounded">
                                    <small class="text-muted d-block">Available Stock:</small>
                                    <span id="stockBadge" class="fw-bold fs-5 text-dark">-</span>
                                </div>
                            </div>
                            <div class="col-md-6 mt-3">
                                <label class="form-label fw-bold">Quantity to Sell</label>
                                <input type="number" name="quantity" id="saleQty" class="form-control form-control-lg" value="1" min="1" required oninput="calculateCounterTotal()">
                            </div>
                        </div>

                        <h6 class="text-secondary fw-bold mb-3">💳 Payment</h6>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label">Payment Type</label>
                                <select name="counter_payment_method" class="form-select" required>
                                    <option value="Cash">Cash (💵)</option>
                                    <option value="Card">Card Terminal (💳)</option>
                                </select>
                            </div>
                            <div class="col-md-6 text-end">
                                <small class="text-muted d-block">Total Bill Amount</small>
                                <h3 class="fw-bold text-primary mt-1">Rs. <span id="billTotal">0</span></h3>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success btn-lg w-100 fw-bold py-3 mt-3 shadow-sm">
                            PROCEED & PRINT INVOICE
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let currentStock = 0;
    let currentPrice = 0;

    function updateLaptopDetails() {
        const select = document.getElementById('laptopSelect');
        const selectedOption = select.options[select.selectedIndex];
        
        if(selectedOption.value !== "") {
            currentStock = parseInt(selectedOption.getAttribute('data-stock'));
            currentPrice = parseFloat(selectedOption.getAttribute('data-price'));
            
            document.getElementById('stockBadge').innerText = currentStock + " Units Available";
            document.getElementById('saleQty').max = currentStock;
            
            calculateCounterTotal();
        }
    }

    function calculateCounterTotal() {
        let qtyInput = document.getElementById('saleQty');
        let qty = parseInt(qtyInput.value);

        if (isNaN(qty) || qty < 1) {
            qtyInput.value = 1;
            qty = 1;
        } else if (qty > currentStock) {
            // ස්ටොක් එකට වඩා වැඩි ප්‍රමාණයක් විකුණන්න හදනකොට එන Alert එක
            alert(`⚠️ Alert: Only ${currentStock} units are available in stock!`);
            qtyInput.value = currentStock;
            qty = currentStock;
        }

        const totalBill = currentPrice * qty;
        document.getElementById('billTotal').innerText = totalBill.toLocaleString();
    }
</script>

</body>
</html>