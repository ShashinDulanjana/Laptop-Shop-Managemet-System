<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $laptop->brand }} {{ $laptop->model }} - Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f4f6f9; font-family: 'Segoe UI', sans-serif; }
        .details-card { background: white; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); overflow: hidden; }
        .btn-back { color: #3498db; text-decoration: none; font-weight: 600; display: flex; align-items: center; gap: 5px; }
        .price-text { color: #2b6cb0; font-size: 2rem; font-weight: 800; }
    </style>
</head>
<body>

<div class="container py-5">
    <a href="{{ route('customer.shop') }}" class="btn-back mb-4">⬅ Back to Shop</a>

    <div class="details-card p-5">
        <div class="row align-items-center">
            <div class="col-md-6 text-center">
                @if($laptop->image)
                    <img src="{{ asset('images/' . $laptop->image) }}" class="img-fluid" style="max-height: 400px; object-fit: contain;" alt="Laptop Image">
                @else
                    <div class="bg-light p-5 rounded text-muted">No Image Available</div>
                @endif
            </div>
            <div class="col-md-6">
                <span class="badge bg-primary mb-2">{{ $laptop->brand }}</span>
                <h1 class="fw-bold mb-3">{{ $laptop->model }}</h1>
                <p class="text-muted mb-4" style="font-size: 1.1rem; line-height: 1.8;">
                    This high-performance laptop features the latest technology, perfect for gaming, development, and professional tasks. 
                    Experience seamless multitasking and high-speed processing.
                </p>

            <div class="mt-4 p-4 bg-gray-50 rounded-lg">
                <h3 class="font-bold text-lg mb-2">Specifications:</h3>
                <p class="text-gray-600">
                 {!! nl2br(e($laptop->specifications)) !!}
               </p>
                <div class="price-text mb-4">Rs. {{ number_format($laptop->price, 0) }}</div>
                
                <div class="d-grid gap-2">
                    <a href="{{ route('laptop.checkout', $laptop->id) }}" class="btn btn-success fw-bold py-2 shadow-sm">
    🛒 BUY NOW
</a>
                    
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>