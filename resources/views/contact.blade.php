<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - LAPTOP SHOP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body { 
            background-color: #f4f6f9; 
            font-family: 'Segoe UI', sans-serif; 
            color: #333;
        }
        .theme-blue { color: #0d6efd; }
        .bg-theme-dark { background-color: #1a202c; }

        /* Navbar Styling (Matching Shop/About View) */
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
        
        /* Sidebar Styling (Matching Shop/About View) */
        .floating-menu {
            position: fixed; top: 68px; left: 0; width: 260px; height: 100vh;
            background-color: #1a202c; box-shadow: 4px 0 10px rgba(0,0,0,0.1);
            z-index: 1050; transition: transform 0.4s ease;
            transform: translateX(-100%); visibility: hidden;
        }
        .floating-menu.show-menu { transform: translateX(0); visibility: visible; }
        .floating-menu .nav-link { color: #a0aec0; padding: 15px 25px; display: block; text-decoration: none; font-weight: 500; font-size: 1.1rem; border-left: 4px solid transparent; transition: 0.3s; }
        .floating-menu .nav-link:hover, .floating-menu .nav-link.active { color: #ffffff; background: rgba(255,255,255,0.05); border-left-color: #3498db; }

        .hero-section {
            background: linear-gradient(135deg, #1a202c 0%, #2d3748 100%);
            color: white;
            padding: 70px 0;
            border-radius: 0 0 30px 30px;
        }
        
        /* Modern Info Cards */
        .contact-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            padding: 30px;
            height: 100%;
        }
        
        .info-item {
            display: flex;
            align-items: center;
            margin-bottom: 25px;
        }
        .info-icon {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            background-color: #e6f0ff;
            color: #0d6efd;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            margin-right: 20px;
        }

        /* Premium Social Media Buttons Styling */
        .social-grid {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            margin-top: 20px;
        }
        .social-btn {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        .social-btn:hover {
            transform: translateY(-5px);
            color: white;
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        }
        /* Real Brand Colors */
        .fb { background: #1877F2; }
        .insta { background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%); }
        .wa { background: #25D366; }
        .yt { background: #FF0000; }
        .linkedin { background: #0077B5; }

        /* Form Inputs Styling */
        .form-control {
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            background-color: #f8fafc;
        }
        .form-control:focus {
            background-color: #fff;
            border-color: #0d6efd;
            box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.15);
        }
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
                <a href="{{ route('about') }}" class="nav-link">ℹ️ About Us</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('contact') }}" class="nav-link active">📞 Contact Us</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('customer.shop') }}" class="nav-link">🏠 Home Page</a>
            </li>
        </ul>
    </div>
</div>

<div class="hero-section text-center mb-5">
    <div class="container">
        <h1 class="display-4 fw-bold mb-3">Get In Touch</h1>
        <p class="lead text-white-50 mx-auto" style="max-width: 600px;">
            Have questions about a laptop configuration or store orders? We are here to help you 24/7.
        </p>
    </div>
</div>

<div class="container my-5">
    <div class="row g-4">
        
        <div class="col-lg-5">
            <div class="contact-card">
                <h3 class="fw-bold mb-4" style="color: #1a202c;">Contact Information</h3>
                <p class="text-muted small mb-4">ඔබට අවශ්‍ය ඕනෑම තොරතුරක් දැනගැනීම සඳහා පහත ක්‍රම මගින් අප හා සම්බන්ධ විය හැක.</p>
                
                <div class="info-item">
                    <div class="info-icon">
                        <i class="fa-solid fa-location-dot"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-1">Our Showroom</h6>
                        <span class="text-muted small">100, Puttalam Road, Kurunegala, Sri Lanka.</span>
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-icon">
                        <i class="fa-solid fa-phone"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-1">Call Us Directly</h6>
                        <span class="text-muted small">+94 76 245 0093 / +94 72 690 5554</span>
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-icon">
                        <i class="fa-solid fa-envelope"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-1">Email Support</h6>
                        <span class="text-muted small">support@laptopshop.lk</span>
                    </div>
                </div>

                <hr class="my-4 opacity-25">

                <h5 class="fw-bold mb-3" style="color: #1a202c;">Follow Our Social Media</h5>
                <div class="social-grid">
                    <a href="#" class="social-btn fb" title="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" class="social-btn insta" title="Instagram"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#" class="social-btn wa" title="WhatsApp"><i class="fa-brands fa-whatsapp"></i></a>
                    <a href="#" class="social-btn yt" title="YouTube"><i class="fa-brands fa-youtube"></i></a>
                    <a href="#" class="social-btn linkedin" title="LinkedIn"><i class="fa-brands fa-linkedin-in"></i></a>
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="contact-card">
                <h3 class="fw-bold mb-4" style="color: #1a202c;">Send Us a Message</h3>
                
                <form action="#" method="POST" onsubmit="event.preventDefault(); alert('Message simulation successful! Your UI looks great.');">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-secondary">Your Name</label>
                            <input type="text" class="form-control" placeholder="John Doe" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-secondary">Email Address</label>
                            <input type="email" class="form-control" placeholder="johndoe@example.com" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-bold text-secondary">Subject</label>
                            <input type="text" class="form-control" placeholder="Inquiry about Laptop Warranty" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-bold text-secondary">Message</label>
                            <textarea class="form-control" rows="5" placeholder="Type your message here..." required></textarea>
                        </div>
                        <div class="col-12 mt-4">
                            <button type="submit" class="btn btn-primary fw-bold w-100 py-3 shadow-sm" style="border-radius: 8px;">
                                <i class="fa-solid fa-paper-plane me-2"></i> SEND MESSAGE
                            </button>
                        </div>
                    </div>
                </form>
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