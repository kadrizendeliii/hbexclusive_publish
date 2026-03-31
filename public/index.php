<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exclusive Doors - Quality Doors & Flooring</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/hbexclusive.css?v=<?php echo filemtime(__DIR__ . '/assets/css/hbexclusive.css'); ?>">
    <style>
        * {
            margin: 0;
            padding: 0;
        }
        
        html {
            height: 100%;
        }
        
        body {
            margin: 0;
            padding: 0;
            min-height: 100vh;
            width: 100%;
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
        }
        
        main {
            flex: 1;
            width: 100%;
        }
        
        footer {
            width: 100%;
            flex-shrink: 0;
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
    </style>
</head>
<body>
    <main>
        <!-- Navigation -->
        <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">ExclusiveDoors</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link" href="#home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#experience">Our Story</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">Why Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#certificates">Certificates</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#locations">Locations</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn-nav-cta" href="products.php">View Products</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="hero-section">
        <div class="container">
            <div class="hero-content">
                <h1 class="hero-title">Quality Doors & Flooring for Your Home</h1>
                <p class="hero-subtitle">Serving families for over 10+ years with premium products and exceptional service. Your trusted partner in home improvement.</p>
                <a href="products.php" class="btn-hero">Browse Products</a>
                <a href="#locations" class="btn-hero btn-hero-secondary">Visit Our Store</a>
            </div>
        </div>
    </section>

    <!-- Trust Bar -->
    <section class="trust-bar">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-6 mb-3 mb-md-0">
                    <div class="trust-item animate-on-scroll">
                        <div class="trust-number">10+</div>
                        <div class="trust-label">Years in Business</div>
                    </div>
                </div>
                <div class="col-md-3 col-6 mb-3 mb-md-0">
                    <div class="trust-item animate-on-scroll">
                        <div class="trust-number">5000+</div>
                        <div class="trust-label">Happy Customers</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="trust-item animate-on-scroll">
                        <div class="trust-number">500+</div>
                        <div class="trust-label">Products Available</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="trust-item animate-on-scroll">
                        <div class="trust-number">100%</div>
                        <div class="trust-label">Quality Guaranteed</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Experience Section -->
    <section id="experience" class="experience-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <div class="animate-on-scroll">
                        <h2 class="section-title">Our Story & Experience</h2>
                        <p class="section-subtitle">Building trust through quality, one home at a time</p>
                        
                        <p class="experience-text">
                            For over 10 years, our family-owned business has been the trusted choice for homeowners seeking premium doors and flooring solutions. What started as a small local shop has grown into a respected name in the industry, but our commitment to quality and personal service remains unchanged.
                        </p>
                        
                        <p class="experience-text">
                            We understand that choosing the right doors and flooring is more than just a purchase; it's an investment in your home and family. That's why we personally inspect every product we offer and stand behind each sale with our comprehensive warranty and expert installation services.
                        </p>
                        
                        <div class="experience-highlight">
                            <strong>Our Promise:</strong> We treat your home like our own. Every product is carefully selected, every installation is professionally handled, and every customer becomes part of our extended family. Your satisfaction is our success.
                        </div>
                        
                        <p class="experience-text">
                            From elegant entry doors that make a lasting first impression to durable flooring that withstands the test of time, we've helped thousands of families transform their houses into homes they're proud of.
                        </p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="animate-on-scroll">
                        <img src="OurStory_img.jpg" alt="Our Experience" class="experience-image">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="about-section">
        <div class="container">
            <div class="text-center mb-5 animate-on-scroll">
                <h2 class="section-title">Why Choose Us</h2>
                <p class="section-subtitle">Quality products, expert service, family values</p>
            </div>
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="about-card animate-on-scroll">
                        <div class="about-icon">
                            <i class="fas fa-certificate"></i>
                        </div>
                        <h4>Premium Quality</h4>
                        <p>We only offer products that meet our high standards. Every item is carefully selected and comes with a quality guarantee.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="about-card animate-on-scroll">
                        <div class="about-icon">
                            <i class="fas fa-tools"></i>
                        </div>
                        <h4>Expert Installation</h4>
                        <p>Our experienced team ensures perfect installation every time. Professional service from start to finish.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="about-card animate-on-scroll">
                        <div class="about-icon">
                            <i class="fas fa-handshake"></i>
                        </div>
                        <h4>Trusted Service</h4>
                        <p>Family-owned and operated. We build lasting relationships with our customers based on trust and reliability.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Certificates Section -->
    <section id="certificates" class="certificates-section">
        <div class="container">
            <div class="text-center mb-5 animate-on-scroll">
                <h2 class="section-title">Our Certificates</h2>
                <p class="section-subtitle">Verified quality and compliance you can trust</p>
            </div>
            <div class="row g-4">
                <div class="col-sm-6 col-xl-3">
                    <article class="certificate-card animate-on-scroll">
                        <div class="certificate-image-frame">
                            <img
                                src="ISO9001.jpg"
                                alt="ISO 9001 certificate"
                                class="certificate-image"
                            >
                        </div>
                        <div class="certificate-content">
                            <h3>ISO 9001</h3>
                            <p>Certificate of Approval</p>
                        </div>
                    </article>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <article class="certificate-card animate-on-scroll">
                        <div class="certificate-image-frame">
                            <img
                                src="ECM.jpg"
                                alt="ECM certificate"
                                class="certificate-image"
                            >
                        </div>
                        <div class="certificate-content">
                            <h3>ECM</h3>
                            <p>Certificate of Compliance</p>
                        </div>
                    </article>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <article class="certificate-card animate-on-scroll">
                        <div class="certificate-image-frame">
                            <img
                                src="TSE.jpg"
                                alt="TSE certificate"
                                class="certificate-image"
                            >
                        </div>
                        <div class="certificate-content">
                            <h3>TSE</h3>
                            <p>Turkish Standard Institute</p>
                        </div>
                    </article>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <article class="certificate-card animate-on-scroll">
                        <div class="certificate-image-frame">
                            <img
                                src="TCMKD.jpg"
                                alt="MKSC certificate"
                                class="certificate-image"
                            >
                        </div>
                        <div class="certificate-content">
                            <h3>MKSC</h3>
                            <p>Macedonian Brand Certification</p>
                        </div>
                    </article>
                </div>
            </div>
        </div>
    </section>

    <!-- Maps Section -->
    <section id="locations" class="locations-section">
        <div class="container">
            <div class="maps-container">
                <div class="text-center mb-5">
                    <h3 class="section-title" style="margin-bottom: 15px;">Visit Our Locations</h3>
                    <p style="color: #666; font-size: 1.05rem;">Find us at multiple convenient locations across the city</p>
                </div>
                <div class="map-frame">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d741.2014374606632!2d20.98973613870616!3d42.00444424531187!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1353f1ef8dcd1ebf%3A0xefaabdd0dba9ab06!2sHB%20Exclusive!5e0!3m2!1sen!2smk!4v1771271408021!5m2!1sen!2smk" width="800" height="600" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 30px; margin-top: 40px;">
                    <div style="text-align: center;">
                        <h4 style="color: #ffdd00; font-weight: 700; margin-bottom: 10px; font-size: 1.2rem;">Palma Mall</h4>
                        <p style="color: #666; margin: 8px 0;"><i class="fas fa-map-marker-alt" style="color: #ffdd00; margin-right: 8px;"></i>Floor-1, Palma Mall 1200 Tetovo</p>
                        <p style="color: #666; margin: 8px 0;"><i class="fas fa-phone" style="color: #ffdd00; margin-right: 8px;"></i>+389 (0) 70 900 075</p>
                    </div>
                    <div style="text-align: center;">
                        <h4 style="color: #ffdd00; font-weight: 700; margin-bottom: 10px; font-size: 1.2rem;">Shipad Store</h4>
                        <p style="color: #666; margin: 8px 0;"><i class="fas fa-map-marker-alt" style="color: #ffdd00; margin-right: 8px;"></i>St. Ilinden 190-1 1200 Tetovo</p>
                        <p style="color: #666; margin: 8px 0;"><i class="fas fa-phone" style="color: #ffdd00; margin-right: 8px;"></i>+389 (0) 70 900 075</p>

                    </div>
                </div>
            </div>

                
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <div class="animate-on-scroll">
                <h2>Ready to Transform Your Home?</h2>
                <p>Browse our extensive collection of doors and flooring options</p>
                <a href="products.php" class="btn-hero">View All Products</a>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Counter animation for trust numbers
        function animateCounter(element, finalValue) {
            let currentValue = 0;
            const increment = finalValue / 50;
            const duration = 2500;
            const stepTime = duration / 50;
            const suffix = element.textContent.replace(/[0-9]/g, '').trim();

            const counter = setInterval(() => {
                currentValue += increment;
                if (currentValue >= finalValue) {
                    currentValue = finalValue;
                    clearInterval(counter);
                }
                element.textContent = Math.floor(currentValue) + suffix;
            }, stepTime);
        }

        // Scroll animation with counter trigger
        function animateOnScroll() {
            const elements = document.querySelectorAll('.animate-on-scroll');
            
            elements.forEach(element => {
                const elementTop = element.getBoundingClientRect().top;
                const elementBottom = element.getBoundingClientRect().bottom;
                
                if (elementTop < window.innerHeight - 100 && elementBottom > 0) {
                    element.classList.add('animated');
                }
            });

            // Trigger counter animations when trust-bar is visible
            const trustBar = document.querySelector('.trust-bar');
            if (trustBar && !trustBar.dataset.counted) {
                const trustTop = trustBar.getBoundingClientRect().top;
                const trustBottom = trustBar.getBoundingClientRect().bottom;
                
                if (trustTop < window.innerHeight - 100 && trustBottom > 0) {
                    const numbers = trustBar.querySelectorAll('.trust-number');
                    numbers.forEach(num => {
                        const finalValue = parseInt(num.textContent);
                        animateCounter(num, finalValue);
                    });
                    trustBar.dataset.counted = 'true';
                }
            }
        }

        // Run on scroll
        window.addEventListener('scroll', animateOnScroll);
        // Run on load
        window.addEventListener('load', animateOnScroll);
    </script>

    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .footer-item {
            animation: fadeInUp 0.8s ease-out;
        }
        
        .footer-item:nth-child(1) { animation-delay: 0.1s; }
        .footer-item:nth-child(2) { animation-delay: 0.3s; }
        .footer-item:nth-child(3) { animation-delay: 0.5s; }
    </style>
    </main>

    <footer>
        <div class="footer-container">
            <div class="footer-section">
                <h5>HB Exclusive</h5>
                <p>Premium doors and flooring solutions for your home. Quality craftsmanship and elegant designs since 2016.</p>
                <div class="footer-social">
                    <a href="https://www.facebook.com/HBExclusive/" target="_blank" rel="noopener noreferrer" aria-label="HB Exclusive on Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://www.instagram.com/hbexclusivenmk/" target="_blank" rel="noopener noreferrer" aria-label="HB Exclusive on Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="https://www.tiktok.com/@exclusive_doors" target="_blank" rel="noopener noreferrer" aria-label="HB Exclusive on TikTok"><i class="fab fa-tiktok"></i></a>
                </div>
            </div>
            <div class="footer-section">
                <h5>Quick Links</h5>
                <ul>
                    <li><a href="index.php">&rarr; Home</a></li>
                    <li><a href="#experience">&rarr; Our Story</a></li>
                    <li><a href="products.php">&rarr; Products</a></li>
                    <li><a href="#locations">&rarr; Locations</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h5>Contact</h5>
                <p><i class="fas fa-phone"></i>+389 (0) 70 900 075 & +389 (0) 70 522 288</p>
                <p><i class="fas fa-envelope"></i>exclusivedoors23@gmail.com</p>
                <p><i class="fas fa-map-marker-alt"></i>Floor-1, Palma Mall 1200 Tetovo & St. Ilinden 190-1 1200 Tetovo</p>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2026 ExclusiveDoors. All rights reserved. Contact us for privacy and terms information.</p>
        </div>
    </footer>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const navbarCollapse = document.getElementById('navbarNav');
            const navLinks = document.querySelectorAll('.navbar-nav .nav-link');

            // Close navbar when clicking any nav link (on all screen sizes)
            navLinks.forEach(link => {
                link.addEventListener('click', function() {
                    if (navbarCollapse.classList.contains('show')) {
                        const collapseInstance = bootstrap.Collapse.getInstance(navbarCollapse);
                        if (collapseInstance) {
                            collapseInstance.hide();
                        }
                    }
                });
            });

            // Smooth scroll for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    const href = this.getAttribute('href');
                    if (href !== '#' && document.querySelector(href)) {
                        e.preventDefault();
                        document.querySelector(href).scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });
        });
    </script>
</body>
</html>
