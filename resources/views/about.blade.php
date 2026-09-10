<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - LAPTOP SHOP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body { 
            background-color: #f4f6f9; 
            font-family: 'Segoe UI', sans-serif; 
            color: #333;
        }
        .theme-blue { color: #0d6efd; }
        .bg-theme-blue { background-color: #0d6efd; }
        .bg-theme-dark { background-color: #1a202c; }

        /* Navbar Styling (Matching Shop View) */
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
        
        /* Sidebar Styling (Matching Shop View) */
        .floating-menu {
            position: fixed; top: 68px; left: 0; width: 260px; height: 100vh;
            background-color: #1a202c; box-shadow: 4px 0 10px rgba(0,0,0,0.1);
            z-index: 1050; transition: transform 0.4s ease;
            transform: translateX(-100%); visibility: hidden;
        }
        .floating-menu.show-menu { transform: translateX(0); visibility: visible; }
        .floating-menu .nav-link { color: #a0aec0; padding: 15px 25px; display: block; text-decoration: none; font-weight: 500; font-size: 1.1rem; border-left: 4px solid transparent; transition: 0.3s; }
        .floating-menu .nav-link:hover, .floating-menu .nav-link.active { color: #ffffff; background: rgba(255,255,255,0.05); border-left-color: #3498db; }

        /* Hero Section */
        .hero-section {
            background: linear-gradient(135deg, #1a202c 0%, #2d3748 100%);
            color: white;
            padding: 80px 0;
            border-radius: 0 0 30px 30px;
        }
        .about-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            transition: transform 0.3s ease;
        }
        .about-card:hover { transform: translateY(-5px); }
        
        .feature-icon {
            width: 60px; height: 60px; border-radius: 50px;
            background-color: #e6f0ff; color: #0d6efd;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.5rem; margin-bottom: 20px;
        }
        .stat-box { border-left: 4px solid #0d6efd; padding-left: 15px; }
    </style>
</head>
<body>

<nav class="custom-navbar shadow-sm">
    <div class="d-flex align-items-center">
        <span class="hamburger-icon" onclick="toggleMyMenu()">☰</span>
        <a href="{{ route('customer.shop') }}" class="brand-text">LAPTOP <span class="text-white">SHOP</span></a>
    </div>
    <a href="{{ url('/dashboard') }}" class="btn btn-danger fw-bold px-4" style="border-radius: 8px;">LOG IN</a>
</nav>

<div class="floating-menu" id="sidebarMenu">
    <div class="py-4">
        <ul class="nav flex-column gap-2">
            <li class="nav-item">
                <a href="{{ route('customer.shop') }}" class="nav-link">🛒 Shop Now</a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/dashboard') }}" class="nav-link">💻 Dashboard</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('about') }}" class="nav-link active">ℹ️ About Us</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('contact') }}" class="nav-link">📞 Contact Us</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('customer.shop') }}" class="nav-link">🏠 Home Page</a>
            </li>
        </ul>
    </div>
</div>

<div class="hero-section text-center mb-5">
    <div class="container">
        <h1 class="display-4 fw-bold mb-3">About LAPTOP SHOP</h1>
        <p class="lead text-white-50 mx-auto" style="max-width: 600px;">
            Powering your productivity with the finest selection of premium, high-performance laptops since 2024.
        </p>
    </div>
</div>

<div class="container my-5">
    <div class="row justify-content-center mb-5">
        <div class="col-lg-8">
            <h6 class="text-uppercase fw-bold theme-blue mb-2">Who We Are</h6>
            <h2 class="fw-bold mb-4" style="color: #1a202c;">Your Ultimate Destination for Premium Technology</h2>
            <p class="text-muted leading-relaxed mb-4">
                Welcome to <strong>LAPTOP SHOP</strong>, where we bridge the gap between innovation and your daily needs. Whether you are a hard-core programmer, a creative graphic designer, an intense gamer, or a business professional, we provide top-tier computing power tailored specifically for your lifestyle.
            </p>
            <p class="text-muted leading-relaxed mb-4">
                අපගේ අරමුණ වන්නේ ශ්‍රී ලංකාවේ සැමටම විශ්වාසදායක, උසස්ම තත්ත්වයේ ජාත්‍යන්තර සන්නාමයන්ගෙන් යුත් ලැප්ටොප් පරිගණක සාධාරණ මිල ගණන් යටතේ සහ වගකීමක් සහිතව ලබාදීමයි.
            </p>
            
            <div class="row g-4 mt-2 justify-content-center justify-content-lg-start">
                <div class="col-auto">
                    <div class="stat-box">
                        <h3 class="fw-bold text-dark mb-0">5K+</h3>
                        <small class="text-muted">Happy Clients</small>
                    </div>
                </div>
                <div class="col-auto ms-lg-4">
                    <div class="stat-box">
                        <h3 class="fw-bold text-dark mb-0">100%</h3>
                        <small class="text-muted">Genuine Brand</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <hr class="my-5 opacity-25">

    <div class="text-center mb-5">
        <h6 class="text-uppercase fw-bold theme-blue mb-2">Why Choose Us</h6>
        <h2 class="fw-bold" style="color: #1a202c;">Our Pillars of Service Excellence</h2>
    </div>

    <div class="row g-4 justify-content-center">
        <div class="col-md-4">
            <div class="about-card p-4 h-100">
                <div class="feature-icon">
                    <i class="fa-solid fa-laptop"></i>
                </div>
                <h5 class="fw-bold mb-3">Premium Global Brands</h5>
                <p class="text-muted small mb-0">
                    We strictly offer authorized premium laptops from globally trusted manufacturing brands like ASUS, HP, Lenovo, and Apple with official international warranties.
                </p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="about-card p-4 h-100">
                <div class="feature-icon">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>
                <h5 class="fw-bold mb-3">Uncompromised Security</h5>
                <p class="text-muted small mb-0">
                    From 256-bit encrypted online card processing to encrypted custom real-time secure OTP authorization modals, user data safely completes checkout pipelines.
                </p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="about-card p-4 h-100">
                <div class="feature-icon">
                    <i class="fa-solid fa-headset"></i>
                </div>
                <h5 class="fw-bold mb-3">Dedicated Support Line</h5>
                <p class="text-muted small mb-0">
                    Our technical and delivery specialists assist customers 24/7 post-purchase, validating seamless machine configuration loops efficiently.
                </p>
            </div>
        </div>
    </div>
</div>

<div class="bg-theme-dark text-white-50 text-center py-4 mt-5">
    <div class="container">
        <small>&copy; 2026 LAPTOP SHOP. All Rights Reserved. Engineered with Pride.</small>
    </div>
</div>

<script>
    function toggleMyMenu() {
        var menu = document.getElementById("sidebarMenu");
        menu.classList.toggle("show-menu");
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>