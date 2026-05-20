<!-- ===== NAVBAR CSS ===== -->
<style>
    /* Base Navbar */
    .custom-nav {
        position: sticky;
        top: 0;
        z-index: 9999;
        background: #ffffff;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        font-family: 'Inter', system-ui, sans-serif;
    }
    .nav-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0.75rem 1.5rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    /* Logo */
    .nav-logo {
        display: flex;
        align-items: center;
        text-decoration: none;
    }
    .nav-logo img {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #e2e8f0;
    }

    /* Desktop Menu */
    .nav-menu {
        list-style: none;
        margin: 0;
        padding: 0;
        display: flex;
        align-items: center;
        gap: 1.5rem;
    }
    .nav-menu a {
        text-decoration: none;
        color: #334155;
        font-weight: 500;
        font-size: 0.95rem;
        transition: color 0.2s;
    }
    .nav-menu a:hover {
        color: #06b6d4;
    }

    /* Desktop CV Button */
    .nav-cv-desktop {
        background: #06b6d4;
        color: white !important;
        padding: 0.5rem 1.25rem;
        border-radius: 999px;
        font-weight: 600;
        font-size: 0.875rem;
        transition: background 0.2s;
    }
    .nav-cv-desktop:hover {
        background: #0891b2;
    }

    /* Hamburger Button (Hidden on Desktop) */
    .burger-btn {
        display: none;
        flex-direction: column;
        justify-content: center;
        gap: 5px;
        background: none;
        border: none;
        cursor: pointer;
        padding: 8px;
        width: 44px;
        height: 44px;
    }
    .burger-btn span {
        display: block;
        width: 24px;
        height: 3px;
        background: #334155;
        border-radius: 2px;
        transition: all 0.3s ease;
    }

    /* ===== MOBILE STYLES (≤768px) ===== */
    @media (max-width: 768px) {
        .burger-btn {
            display: flex; /* Show hamburger */
        }
        .nav-cv-desktop {
            display: none; /* Hide desktop CV */
        }
        .nav-cv-mobile {
            display: block !important;
        }
        
        /* Hide menu by default on mobile */
        .nav-menu {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            flex-direction: column;
            background: #ffffff;
            padding: 1rem 0;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            border-top: 1px solid #e2e8f0;
            z-index: 9998;
        }
        
        /* Show menu when .active class is added */
        .nav-menu.active {
            display: flex;
        }
        
        .nav-menu li {
            width: 100%;
            border-bottom: 1px solid #f1f5f9;
        }
        .nav-menu li:last-child {
            border-bottom: none;
        }
        .nav-menu a {
            display: block;
            padding: 1rem 1.5rem;
            text-align: center;
            font-size: 1rem;
        }
        .nav-cv-mobile {
            display: block;
            padding: 1rem 1.5rem;
            text-align: center;
            background: #f8fafc;
            margin-top: 0.5rem;
        }
        .nav-cv-mobile a {
            display: inline-block;
            background: #06b6d4;
            color: white !important;
            padding: 0.5rem 1.25rem;
            border-radius: 999px;
            font-weight: 600;
            text-decoration: none;
            width: 80%;
        }
    }
    @media (min-width: 769px) {
        .nav-cv-mobile { display: none !important; }
    }

    /* Burger Animation to X */
    .burger-btn.open span:nth-child(1) { transform: rotate(45deg) translate(5px, 6px); }
    .burger-btn.open span:nth-child(2) { opacity: 0; }
    .burger-btn.open span:nth-child(3) { transform: rotate(-45deg) translate(5px, -6px); }
</style>

<!-- ===== NAVBAR HTML ===== -->
<nav class="custom-nav">
    <div class="nav-container">
        <!-- Logo -->
        <a href="/" class="nav-logo">
            <img src="{{ Storage::url('images/abd_logo.jpeg') }}" alt="Site Logo">
        </a>

        <!-- Menu Links -->
        <ul class="nav-menu" id="navMenu">
            <li><a href="/#home">Home</a></li>
            <li><a href="/#about">About</a></li>
            <li><a href="/#projects">Projects</a></li>
            <li><a href="/#skills">Skills</a></li>
            <li><a href="/#contact">Contact</a></li>
            <!-- Mobile CV Button -->
            <li class="nav-cv-mobile">
                <a href="/cv.pdf" target="_blank">Download CV</a>
            </li>
        </ul>

        <!-- Desktop CV Button -->
        <a href="/cv.pdf" target="_blank" class="nav-cv-desktop">Download CV</a>

        <!-- Hamburger Button -->
        <button class="burger-btn" id="burgerBtn" aria-label="Toggle menu">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </div>
</nav>

<!-- ===== JAVASCRIPT ===== -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const burger = document.getElementById('burgerBtn');
    const menu = document.getElementById('navMenu');

    // Safety check to ensure elements exist
    if (!burger || !menu) {
        console.error('❌ Navbar elements not found! Check HTML IDs.');
        return;
    }

    // Toggle menu
    burger.addEventListener('click', function() {
        menu.classList.toggle('active');
        this.classList.toggle('open');
        
        // Prevent background scrolling when menu is open
        document.body.style.overflow = menu.classList.contains('active') ? 'hidden' : '';
    });

    // Close menu when clicking any link
    menu.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', function() {
            menu.classList.remove('active');
            burger.classList.remove('open');
            document.body.style.overflow = '';
        });
    });

    // Close menu when clicking outside
    document.addEventListener('click', function(e) {
        if (!menu.contains(e.target) && !burger.contains(e.target) && menu.classList.contains('active')) {
            menu.classList.remove('active');
            burger.classList.remove('open');
            document.body.style.overflow = '';
        }
    });

    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if (href.length > 1) {
                e.preventDefault();
                const target = document.querySelector(href);
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            }
        });
    });
});
</script>