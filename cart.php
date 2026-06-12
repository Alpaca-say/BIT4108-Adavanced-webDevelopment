<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elysee — Curated Home Living</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<!-- ===== NAVIGATION ===== -->
<nav class="navbar" id="navbar">
    <div class="nav-inner">
        <a href="#" class="logo" onclick="showSection('home')">
            <span class="logo-mark">✦</span>
            <span class="logo-text">Elysee</span>
        </a>
        <div class="nav-links">
            <a href="#" onclick="showSection('home'); filterCategory('')">Home</a>
            <a href="#" onclick="showSection('catalog'); filterCategory('')">Catalog</a>
            <a href="#" onclick="showSection('catalog'); filterCategory('furniture')">Furniture</a>
            <a href="#" onclick="showSection('catalog'); filterCategory('utensils')">Utensils</a>
            <a href="#" onclick="showSection('catalog'); filterCategory('appliances')">Appliances</a>
            <a href="#" onclick="showSection('catalog'); filterCategory('extras')">Extras</a>
        </div>
        <div class="nav-actions">
            <div class="search-wrap">
                <input type="text" id="searchInput" placeholder="Search products…" oninput="handleSearch()">
                <span class="search-icon">⌕</span>
            </div>
            <button class="cart-btn" onclick="showSection('cart')">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
                <span class="cart-count" id="cartCount">0</span>
            </button>
            <div class="user-menu" id="userMenu">
                <button class="btn-outline" id="authBtn" onclick="showSection('auth')">Sign In</button>
                <div class="user-dropdown" id="userDropdown" style="display:none">
                    <span id="userGreeting">Hello!</span>
                    <button onclick="showSection('admin')" id="adminBtn">Manage Products</button>
                    <button onclick="logout()">Sign Out</button>
                </div>
            </div>
        </div>
        <button class="hamburger" onclick="toggleMobileMenu()">☰</button>
    </div>
    <div class="mobile-menu" id="mobileMenu">
        <a href="#" onclick="showSection('home'); toggleMobileMenu()">Home</a>
        <a href="#" onclick="showSection('catalog'); filterCategory(''); toggleMobileMenu()">All Products</a>
        <a href="#" onclick="showSection('catalog'); filterCategory('furniture'); toggleMobileMenu()">Furniture</a>
        <a href="#" onclick="showSection('catalog'); filterCategory('utensils'); toggleMobileMenu()">Utensils</a>
        <a href="#" onclick="showSection('catalog'); filterCategory('appliances'); toggleMobileMenu()">Appliances</a>
        <a href="#" onclick="showSection('catalog'); filterCategory('extras'); toggleMobileMenu()">Extras</a>
    </div>
</nav>

<!-- ===== TOAST ===== -->
<div class="toast" id="toast"></div>

<!-- ===== HOME SECTION ===== -->
<section id="section-home" class="section active">

    <!-- Hero -->
    <div class="hero">
        <div class="hero-bg">
            <div class="hero-shape shape-1"></div>
            <div class="hero-shape shape-2"></div>
            <div class="hero-shape shape-3"></div>
        </div>
        <div class="hero-content">
            <p class="hero-eyebrow">New Collection 2025</p>
            <h1 class="hero-title">Your Home,<br><em>Elevated.</em></h1>
            <p class="hero-sub">Curated furniture, artisan kitchenware, and home appliances<br>designed for a life lived beautifully.</p>
            <div class="hero-cta">
                <button class="btn-primary" onclick="showSection('catalog'); filterCategory('')">Shop the Collection</button>
                <button class="btn-ghost" onclick="showSection('catalog'); filterCategory('furniture')">View Furniture →</button>
            </div>
        </div>
        <div class="hero-image">
            <div class="hero-img-frame">
                <img src="https://images.unsplash.com/photo-1555041469-a586c61ea9bc?w=700&q=80" alt="Hero sofa" loading="lazy">
                <div class="hero-tag">
                    <span class="tag-label">Featured</span>
                    <span class="tag-name">Nordic Linen Sofa</span>
                    <span class="tag-price">$1,249</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Categories Strip -->
    <div class="categories-strip">
        <div class="cat-card" onclick="showSection('catalog'); filterCategory('furniture')">
            <div class="cat-icon">🪑</div>
            <span>Furniture</span>
        </div>
        <div class="cat-card" onclick="showSection('catalog'); filterCategory('utensils')">
            <div class="cat-icon">🍳</div>
            <span>Utensils</span>
        </div>
        <div class="cat-card" onclick="showSection('catalog'); filterCategory('appliances')">
            <div class="cat-icon">🏠</div>
            <span>Appliances</span>
        </div>
        <div class="cat-card" onclick="showSection('catalog'); filterCategory('extras')">
            <div class="cat-icon">✨</div>
            <span>Extras</span>
        </div>
    </div>

    <!-- Featured Products -->
    <div class="section-block">
        <div class="section-header">
            <h2 class="section-title">Bestsellers</h2>
            <a href="#" onclick="showSection('catalog'); filterCategory('')" class="see-all">View All →</a>
        </div>
        <div class="products-grid" id="featuredGrid">
            <div class="loading-spinner">Loading products…</div>
        </div>
    </div>

    <!-- Banner -->
    <div class="promo-banner">
        <div class="promo-content">
            <h2>Free Delivery on Orders Over $300</h2>
            <p>Plus hassle-free 30-day returns on everything in the catalog.</p>
            <button class="btn-primary" onclick="showSection('catalog'); filterCategory('')">Shop Now</button>
        </div>
    </div>
</section>

<!-- ===== CATALOG SECTION ===== -->
<section id="section-catalog" class="section">
    <div class="catalog-layout">
        <!-- Sidebar -->
        <aside class="catalog-sidebar">
            <h3>Filter</h3>
            <div class="filter-group">
                <p class="filter-label">Category</p>
                <button class="filter-btn active" onclick="filterCategory('')" data-cat="">All</button>
                <button class="filter-btn" onclick="filterCategory('furniture')" data-cat="furniture">Furniture</button>
                <button class="filter-btn" onclick="filterCategory('utensils')" data-cat="utensils">Utensils</button>
                <button class="filter-btn" onclick="filterCategory('appliances')" data-cat="appliances">Appliances</button>
                <button class="filter-btn" onclick="filterCategory('extras')" data-cat="extras">Extras</button>
            </div>
            <div class="filter-group">
                <p class="filter-label">Sort By</p>
                <select id="sortSelect" onchange="loadCatalog()">
                    <option value="id">Default</option>
                    <option value="price_asc">Price: Low → High</option>
                    <option value="price_desc">Price: High → Low</option>
                    <option value="name">Name A–Z</option>
                </select>
            </div>
        </aside>
        <!-- Products -->
        <div class="catalog-main">
            <div class="catalog-topbar">
                <h2 id="catalogTitle">All Products</h2>
                <span id="catalogCount" class="product-count"></span>
            </div>
            <div class="products-grid" id="catalogGrid">
                <div class="loading-spinner">Loading products…</div>
            </div>
        </div>
    </div>
</section>

<!-- ===== CART SECTION ===== -->
<section id="section-cart" class="section">
    <div class="page-header">
        <h2>Your Cart</h2>
    </div>
    <div class="cart-layout" id="cartLayout">
        <div class="loading-spinner">Loading cart…</div>
    </div>
</section>

<!-- ===== AUTH SECTION ===== -->
<section id="section-auth" class="section">
    <div class="auth-container">
        <div class="auth-art">
            <img src="https://images.unsplash.com/photo-1586023492125-27b2c045efd7?w=700&q=80" alt="Home decor">
            <div class="auth-art-overlay">
                <div class="auth-logo">✦ Elysee</div>
                <p>Beautiful homes<br>start here.</p>
            </div>
        </div>
        <div class="auth-form-side">
            <div class="auth-tabs">
                <button class="auth-tab active" onclick="switchAuthTab('login')" id="tab-login">Sign In</button>
                <button class="auth-tab" onclick="switchAuthTab('register')" id="tab-register">Register</button>
            </div>

            <!-- Login Form -->
            <form class="auth-form" id="loginForm" onsubmit="handleLogin(event)">
                <h2>Welcome back</h2>
                <p class="form-sub">Sign in to your Elysee account</p>
                <div class="field-group">
                    <label>Email Address</label>
                    <input type="email" id="loginEmail" placeholder="you@example.com" required>
                    <span class="field-error" id="loginEmailErr"></span>
                </div>
                <div class="field-group">
                    <label>Password</label>
                    <div class="password-wrap">
                        <input type="password" id="loginPassword" placeholder="Your password" required>
                        <button type="button" class="toggle-pw" onclick="togglePw('loginPassword', this)">Show</button>
                    </div>
                    <span class="field-error" id="loginPasswordErr"></span>
                </div>
                <button type="submit" class="btn-primary full-width" id="loginBtn">Sign In</button>
                <span class="form-switch">Don't have an account? <a href="#" onclick="switchAuthTab('register')">Register</a></span>
            </form>

            <!-- Register Form -->
            <form class="auth-form" id="registerForm" style="display:none" onsubmit="handleRegister(event)">
                <h2>Create account</h2>
                <p class="form-sub">Join Elysee for a better home</p>
                <div class="field-group">
                    <label>Full Name</label>
                    <input type="text" id="regName" placeholder="Jane Doe" required>
                    <span class="field-error" id="regNameErr"></span>
                </div>
                <div class="field-group">
                    <label>Email Address</label>
                    <input type="email" id="regEmail" placeholder="you@example.com" required>
                    <span class="field-error" id="regEmailErr"></span>
                </div>
                <div class="field-group">
                    <label>Password</label>
                    <div class="password-wrap">
                        <input type="password" id="regPassword" placeholder="Min. 8 characters" required>
                        <button type="button" class="toggle-pw" onclick="togglePw('regPassword', this)">Show</button>
                    </div>
                    <span class="field-error" id="regPasswordErr"></span>
                    <div class="pw-strength" id="pwStrength"></div>
                </div>
                <div class="field-group">
                    <label>Confirm Password</label>
                    <input type="password" id="regConfirm" placeholder="Repeat password" required>
                    <span class="field-error" id="regConfirmErr"></span>
                </div>
                <button type="submit" class="btn-primary full-width" id="registerBtn">Create Account</button>
                <span class="form-switch">Already have an account? <a href="#" onclick="switchAuthTab('login')">Sign In</a></span>
            </form>
        </div>
    </div>
</section>

<!-- ===== ADMIN SECTION ===== -->
<section id="section-admin" class="section">
    <div class="admin-container">
        <div class="admin-header">
            <h2>Product Management</h2>
            <button class="btn-primary" onclick="openProductModal()">+ Add Product</button>
        </div>
        <div class="admin-table-wrap">
            <table class="admin-table" id="adminTable">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Badge</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="adminTableBody">
                    <tr><td colspan="6" class="loading-spinner">Loading…</td></tr>
                </tbody>
            </table>
        </div>
    </div>
</section>

<!-- ===== PRODUCT DETAIL MODAL ===== -->
<div class="modal-overlay" id="detailModal" onclick="closeDetailModal(event)">
    <div class="modal-box detail-modal">
        <button class="modal-close" onclick="closeModal('detailModal')">✕</button>
        <div id="detailContent"></div>
    </div>
</div>

<!-- ===== ADMIN PRODUCT MODAL ===== -->
<div class="modal-overlay" id="productModal" onclick="closeDetailModal(event)">
    <div class="modal-box form-modal">
        <button class="modal-close" onclick="closeModal('productModal')">✕</button>
        <h3 id="productModalTitle">Add Product</h3>
        <form id="productForm" onsubmit="handleProductSubmit(event)">
            <input type="hidden" id="productId">
            <div class="field-group">
                <label>Product Name *</label>
                <input type="text" id="pName" required placeholder="e.g. Nordic Linen Sofa">
            </div>
            <div class="form-row">
                <div class="field-group">
                    <label>Category *</label>
                    <select id="pCategory" required></select>
                </div>
                <div class="field-group">
                    <label>Price (KES) *</label>
                    <input type="number" id="pPrice" required min="1" step="0.01" placeholder="0.00">
                </div>
            </div>
            <div class="field-group">
                <label>Description</label>
                <textarea id="pDesc" rows="3" placeholder="Product description…"></textarea>
            </div>
            <div class="field-group">
                <label>Image URL</label>
                <input type="url" id="pImage" placeholder="https://…">
            </div>
            <div class="field-group">
                <label>Badge (optional)</label>
                <input type="text" id="pBadge" placeholder="e.g. New, Bestseller, Premium">
            </div>
            <div class="form-actions">
                <button type="button" class="btn-outline" onclick="closeModal('productModal')">Cancel</button>
                <button type="submit" class="btn-primary" id="productSubmitBtn">Add Product</button>
            </div>
        </form>
    </div>
</div>

<!-- ===== FOOTER ===== -->
<footer class="footer">
    <div class="footer-inner">
        <div class="footer-brand">
            <div class="logo"><span class="logo-mark">✦</span><span class="logo-text">Elysee</span></div>
            <p>Curated home living since 2025.<br>School project by [Your Name].</p>
        </div>
        <div class="footer-links">
            <h4>Catalog</h4>
            <a href="#" onclick="showSection('catalog'); filterCategory('furniture')">Furniture</a>
            <a href="#" onclick="showSection('catalog'); filterCategory('utensils')">Utensils</a>
            <a href="#" onclick="showSection('catalog'); filterCategory('appliances')">Appliances</a>
            <a href="#" onclick="showSection('catalog'); filterCategory('extras')">Extras</a>
        </div>
        <div class="footer-links">
            <h4>Account</h4>
            <a href="#" onclick="showSection('auth')">Sign In</a>
            <a href="#" onclick="showSection('auth'); switchAuthTab('register')">Register</a>
            <a href="#" onclick="showSection('cart')">Your Cart</a>
        </div>
        <div class="footer-links">
            <h4>Info</h4>
            <a href="#">About Elysee</a>
            <a href="#">Delivery Info</a>
            <a href="#">Returns</a>
            <a href="#">Contact</a>
        </div>
    </div>
    <div class="footer-bottom">
        <p>© 2025 Elysee Home Living. All rights reserved. | School Project</p>
    </div>
</footer>

<script src="js/main.js"></script>
</body>
</html>
