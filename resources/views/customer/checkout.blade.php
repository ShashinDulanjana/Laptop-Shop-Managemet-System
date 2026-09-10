<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Laptop Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f4f6f9; font-family: 'Segoe UI', sans-serif; }
        .checkout-card { background: white; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); }
        .payment-option { border: 2px solid #e2e8f0; border-radius: 10px; padding: 15px; cursor: pointer; transition: 0.3s; }
        .payment-option:hover { border-color: #3498db; background: #f8fbff; }
        .form-check-input:checked + .payment-label { color: #3498db; font-weight: bold; }
        
        /* Card Form Container Styling */
        .card-details-box {
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            background-color: #f8fafc;
            display: none; /* Initially hidden */
            transition: all 0.4s ease-in-out;
        }
        .card-form-title {
            color: #3498db;
            font-size: 1.05rem;
            font-weight: 700;
        }
    </style>
</head>
<body>

<nav class="navbar shadow-sm px-4 py-3" style="background-color: #1a202c;">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <a href="#" class="navbar-brand fw-bold text-uppercase m-0" style="color: #3498db; font-size: 1.4rem; letter-spacing: 1px;">
            LAPTOP <span class="text-white">SHOP</span>
        </a>
        <a href="{{ route('customer.shop') }}" class="btn btn-outline-light fw-bold px-3 d-flex align-items-center gap-2" style="border-radius: 8px; font-size: 0.95rem; border-color: rgba(255,255,255,0.3);">
            ← Back to Shop
        </a>
    </div>
</nav>

<div class="container py-4"> 
    <div class="row">
        <div class="col-lg-7 mb-4">
            <div class="checkout-card p-4">
                <h4 class="fw-bold mb-4">🚚 Delivery & Customer Details</h4>
                
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert" style="border-radius: 10px; background-color: #d1e7dd; color: #0f5132;">
                        <strong>🎉 Order Successful!</strong> Your order has been placed. Expect your delivery within 3 working days. Thank you!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert" style="border-radius: 10px; background-color: #f8d7da; color: #842029;">
                        <ul class="mb-0 text-start" style="list-style-type: none; padding-left: 0; font-weight: bold;">
                            @foreach ($errors->all() as $error)
                                <li>❌ {{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form action="{{ route('order.confirm') }}" method="POST" id="checkoutForm">
                    @csrf
                    <input type="hidden" name="laptop_id" value="{{ $laptop->id }}">
                    <input type="hidden" name="otp" id="hiddenOtp">
                    
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Enter your full name" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Phone Number</label>
                            <input type="tel" id="phoneNumber" name="phone" class="form-control" placeholder="07X XXX XXXX" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email (Optional)</label>
                            <input type="email" name="email" class="form-control" placeholder="example@mail.com">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Delivery Address</label>
                            <textarea name="address" class="form-control" rows="3" placeholder="Enter your full address" required></textarea>
                        </div>

                        <div class="col-md-6 mt-3">
                            <label class="form-label fw-bold">Select Quantity</label>
                            <input type="number" name="quantity" id="quantityInput" class="form-control" value="1" min="1" max="{{ $laptop->stock }}" required oninput="calculateTotal()">
                        </div>
                    </div>

                    <h4 class="fw-bold mt-5 mb-4">💳 Payment Method</h4>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="payment-option">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="payment_method" id="cod" value="COD" checked>
                                    <label class="form-check-label payment-label" for="cod">
                                        💵 Cash on Delivery (COD)
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="payment-option">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="payment_method" id="card" value="CARD">
                                    <label class="form-check-label payment-label" for="card">
                                        💳 Online Card Payment
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="cardDetailsContainer" class="card-details-box p-4 mt-4">
                        <div class="card-form-title mb-3">
                            🔒 256-Bit Encrypted Card Payment Form
                        </div>
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label small fw-bold text-secondary">Card Holder Name</label>
                                <input type="text" id="cardName" name="card_name" class="form-control bg-white" placeholder="John Doe">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label small fw-bold text-secondary">Card Number</label>
                                <input type="text" id="cardNumber" name="card_number" class="form-control bg-white" placeholder="0000 0000 0000 0000" inputmode="numeric" maxlength="19">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-secondary">Expiry Date</label>
                                <input type="text" id="cardExpiry" name="card_expiry" class="form-control bg-white" placeholder="MM/YY" inputmode="numeric" maxlength="5">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-secondary">CVC/CVV</label>
                                <input type="text" id="cardCvc" name="card_cvc" class="form-control bg-white" placeholder="123" inputmode="numeric" maxlength="4">
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg w-100 mt-5 fw-bold py-3" style="border-radius: 10px;" id="confirmBtn">
                        CONFIRM ORDER (Rs. <span id="btnPrice">{{ number_format($laptop->price, 0) }}</span>)
                    </button>
                </form>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="checkout-card p-4 sticky-top" style="top: 20px;">
                <h4 class="fw-bold mb-4">📦 Order Summary</h4>
                
                <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                    <img src="{{ asset('images/' . $laptop->image) }}" width="80" class="rounded me-3" alt="Laptop" style="object-fit: contain; max-height: 80px;">
                    <div>
                        <h6 class="fw-bold mb-0 text-uppercase" style="font-size: 0.95rem;">{{ $laptop->brand }}</h6>
                        <small class="text-muted d-block mb-1">{{ $laptop->model }}</small>
                        <span class="fw-bold small text-secondary">Rs. {{ number_format($laptop->price, 0) }}</span>
                    </div>
                </div>
                
                <div class="d-flex justify-content-between mb-2 mt-3">
                    <span class="text-muted">Subtotal</span>
                    <span class="fw-semibold">Rs. <span id="summarySubtotal">{{ number_format($laptop->price, 0) }}</span></span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Delivery Fee</span>
                    <span class="text-success fw-bold">FREE</span>
                </div>
                <hr>
                <div class="d-flex justify-content-between mb-0 align-items-center">
                    <span class="text-muted" style="font-size: 1.1rem;">Total Amount</span>
                    <h5 class="fw-bold text-primary mb-0">Rs. <span id="displayTotal">{{ number_format($laptop->price, 0) }}</span></h5>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="otpModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="otpModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 15px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold text-dark" id="otpModalLabel">🔒 Security Verification</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center px-4 pb-4">
                <div class="mb-3" style="font-size: 3.5rem;">📱</div>
                <h5 class="fw-bold mb-2">Enter OTP Verification Code</h5>
                <p class="text-muted small px-2">We have simulated sending a 4-digit security code to your phone number. Please type it below to confirm your order.</p>
                <p class="text-primary small fw-bold mb-3">(💡 Live Demo Hint: Use Test OTP <span class="badge bg-primary fs-6">1234</span>)</p>
                
                <div class="mx-auto" style="max-width: 200px;">
                    <input type="text" id="otpInputField" class="form-control form-control-lg text-center fw-bold fs-2" placeholder="0000" inputmode="numeric" maxlength="4" style="letter-spacing: 8px; border-radius: 10px; border: 2px solid #3498db; background-color: #f8fbff;">
                </div>
            </div>
            <div class="modal-footer border-0 d-flex gap-2 px-4 pb-4">
                <button type="button" class="btn btn-light w-100 py-2 fw-semibold" data-bs-dismiss="modal" style="border-radius: 10px;">Cancel</button>
                <button type="button" id="verifyOtpBtn" class="btn btn-success w-100 py-2 fw-bold" style="border-radius: 10px;">Verify & Place Order</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    const unitPrice = {{ $laptop->price }};
    const maxStock = {{ $laptop->stock }}; 

    function calculateTotal() {
        let qty = parseInt(document.getElementById('quantityInput').value);
        
        // Safe check without throwing annoying live alerts while typing
        let calcQty = (isNaN(qty) || qty < 1) ? 1 : qty;

        const total = unitPrice * calcQty;
        const formattedTotal = total.toLocaleString();

        document.getElementById('displayTotal').innerText = formattedTotal;
        document.getElementById('summarySubtotal').innerText = formattedTotal;
        document.getElementById('btnPrice').innerText = formattedTotal;
    }

    const codRadio = document.getElementById('cod');
    const cardRadio = document.getElementById('card');
    const cardDetailsContainer = document.getElementById('cardDetailsContainer');
    
    const cardName = document.getElementById('cardName');
    const cardNumber = document.getElementById('cardNumber');
    const cardExpiry = document.getElementById('cardExpiry');
    const cardCvc = document.getElementById('cardCvc');
    const phoneNumber = document.getElementById('phoneNumber');

    function togglePaymentFields() {
        if (cardRadio.checked) {
            cardDetailsContainer.style.display = 'block';
            cardName.required = true;
            cardNumber.required = true;
            cardExpiry.required = true;
            cardCvc.required = true;
        } else {
            cardDetailsContainer.style.display = 'none';
            cardName.required = false;
            cardNumber.required = false;
            cardExpiry.required = false;
            cardCvc.required = false;
        }
    }

    codRadio.addEventListener('change', togglePaymentFields);
    cardRadio.addEventListener('change', togglePaymentFields);

    phoneNumber.addEventListener('input', function(e) {
        e.target.value = e.target.value.replace(/\D/g, '').substring(0, 10);
    });

    const fullNameInput = document.querySelector('input[name="name"]');
    fullNameInput.addEventListener('input', function(e) {
        e.target.value = e.target.value.replace(/[^a-zA-Z\s]/g, '');
    });

    cardName.addEventListener('input', function(e) {
        e.target.value = e.target.value.replace(/[^a-zA-Z\s]/g, '');
    });

    cardNumber.addEventListener('input', function (e) {
        let value = e.target.value.replace(/\D/g, ''); 
        let formatted = value.match(/.{1,4}/g)?.join(' ') || value;
        e.target.value = formatted;
    });

    cardExpiry.addEventListener('input', function (e) {
        let value = e.target.value.replace(/\D/g, ''); 
        if (value.length > 2) {
            e.target.value = value.substring(0, 2) + '/' + value.substring(2, 4);
        } else {
            e.target.value = value;
        }
    });

    cardCvc.addEventListener('input', function (e) {
        e.target.value = e.target.value.replace(/\D/g, ''); 
    });

    document.getElementById('otpInputField').addEventListener('input', function (e) {
        e.target.value = e.target.value.replace(/\D/g, ''); 
    });

    document.getElementById('checkoutForm').addEventListener('submit', function (e) {
        let qty = parseInt(document.getElementById('quantityInput').value);

        // 1. Stock Validation right when clicking Confirm Order
        if (isNaN(qty) || qty < 1) {
            alert('⚠️ Please enter a valid quantity!');
            document.getElementById('quantityInput').focus();
            e.preventDefault();
            return;
        }

        if (qty > maxStock) {
            alert(`⚠️ Only ${maxStock} items are available!`);
            document.getElementById('quantityInput').value = maxStock;
            calculateTotal();
            document.getElementById('quantityInput').focus();
            e.preventDefault();
            return; // Stops here, OTP modal won't show!
        }

        // 2. Phone validation
        if (phoneNumber.value.length < 10) {
            alert('⚠️ Invalid Phone Number! Please enter a valid 10-digit phone number.');
            phoneNumber.focus();
            e.preventDefault();
            return;
        }

        // 3. Card validation
        if (cardRadio.checked) {
            const cleanCardNumber = cardNumber.value.replace(/\s/g, '');
            const expiryValue = cardExpiry.value;
            const cvcValue = cardCvc.value;

            if (cardName.value.trim() === "") {
                alert('⚠️ Please enter the Card Holder Name.');
                cardName.focus();
                e.preventDefault();
                return;
            }

            if (cleanCardNumber.length < 16) {
                alert('⚠️ Invalid Card Number! Please enter a complete 16-digit card number.');
                cardNumber.focus();
                e.preventDefault(); 
                return;
            }

            if (expiryValue.length < 5) {
                alert('⚠️ Invalid Expiry Date! Please use the MM/YY format (e.g., 12/28).');
                cardExpiry.focus();
                e.preventDefault();
                return;
            }

            const expiryParts = expiryValue.split('/');
            const month = parseInt(expiryParts[0], 10);
            const year = parseInt(expiryParts[1], 10);
            
            const currentDate = new Date();
            const currentYearShort = currentDate.getFullYear() % 100; 
            const currentMonth = currentDate.getMonth() + 1; 

            if (month < 1 || month > 12 || isNaN(month)) {
                alert('⚠️ Invalid Month! Expiry month must be between 01 and 12.');
                cardExpiry.focus();
                e.preventDefault();
                return;
            }

            if (isNaN(year) || year < currentYearShort) {
                alert('⚠️ Invalid Year! Expiry year cannot be in the past.');
                cardExpiry.focus();
                e.preventDefault();
                return;
            }

            if (year === currentYearShort && month < currentMonth) {
                alert('⚠️ Invalid Expiry Date! This card has already expired.');
                cardExpiry.focus();
                e.preventDefault();
                return;
            }

            if (cvcValue.length < 3) {
                alert('⚠️ Invalid CVC/CVV! Please enter a valid 3 or 4 digit security code.');
                cardCvc.focus();
                e.preventDefault();
                return;
            }
        }

        e.preventDefault(); 
        const myOtpModal = new bootstrap.Modal(document.getElementById('otpModal'));
        myOtpModal.show(); 
    });

    document.getElementById('verifyOtpBtn').addEventListener('click', function() {
        const userEnteredOtp = document.getElementById('otpInputField').value;
        
        if (userEnteredOtp === '1234') {
            document.getElementById('hiddenOtp').value = userEnteredOtp;
            document.getElementById('checkoutForm').submit();
        } else {
            alert('❌ Invalid Verification Code! Please check the code and try again. (Hint: 1234)');
            document.getElementById('otpInputField').value = '';
            document.getElementById('otpInputField').focus();
        }
    });
</script>

</body>
</html>