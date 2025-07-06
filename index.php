<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Flover - Boutique en ligne</title>
  <script src="https://kit.fontawesome.com/9f6048c82e.js" crossorigin="anonymous"></script>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    html {
      scroll-behavior: smooth;
    }

    body {
      font-family: "Poppins", sans-serif;
      background-color: #111;
      color: #fff;
      padding-top: 0; /* Header caché au départ */
    }

    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background-color: rgba(17, 17, 17, 0.9);
      padding: 20px;
      box-shadow: 0 0 15px #ff5c8d88;
      position: fixed;
      width: 100%;
      top: 0;
      left: 0;
      z-index: 10;
      opacity: 1;
      transform: translateY(0);
      pointer-events: auto;
      transition: opacity 0.5s ease, transform 0.5s ease;
    }

    /* Header caché */
    .header.hidden {
      opacity: 0;
      pointer-events: none;
      transform: translateY(-100%);
      transition: opacity 0.5s ease, transform 0.5s ease;
    }

    .logo {
      font-size: 2rem;
      color: #ff5c8d;
      text-shadow: 0 0 8px #ff5c8d88;
    }

    .nav-links {
      display: flex;
      align-items: center;
      gap: 20px;
    }

    .nav-links a {
      color: #fff;
      text-decoration: none;
      font-weight: bold;
      padding: 8px 14px;
      border-radius: 15px;
      transition: background-color 0.3s ease;
    }

    .nav-links a:hover {
      background-color: #ff5c8d;
    }

    /* Bouton panier */
    #cart-bubble {
      background-color: #ff5c8d;
      border-radius: 50%;
      padding: 10px;
      position: relative;
      font-size: 18px;
      color: #fff;
      cursor: pointer;
      border: none;
      display: flex;
      justify-content: center;
      align-items: center;
      width: 40px;
      height: 40px;
    }

    #cart-bubble:hover {
      transform: scale(1.1);
      transition: transform 0.2s ease;
    }

    #cart-count {
      position: absolute;
      top: -6px;
      right: -6px;
      background-color: #fff;
      color: #ff5c8d;
      border-radius: 50%;
      padding: 2px 7px;
      font-size: 12px;
      font-weight: bold;
      user-select: none;
      pointer-events: none;
    }

    .cart-panel {
      position: fixed;
      top: 70px;
      right: 20px;
      background: #1a1a1a;
      border: 1px solid #ff5c8d88;
      padding: 15px;
      border-radius: 10px;
      width: 280px;
      max-height: 300px;
      overflow-y: auto;
      color: #fff;
      box-shadow: 0 0 15px #ff5c8d55;
      z-index: 15;
      display: none;
      font-size: 14px;
    }

    .cart-panel h4 {
      margin-bottom: 10px;
      text-align: center;
      font-weight: bold;
      color: #ff5c8d;
    }

    .cart-panel ul {
      list-style: none;
      margin-bottom: 10px;
    }

    .cart-panel li {
      margin-bottom: 6px;
      border-bottom: 1px solid #333;
      padding-bottom: 4px;
    }

    .cart-panel p.total {
      font-weight: bold;
      text-align: right;
      color: #ff5c8d;
    }

    .hero-section {
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;
      text-align: center;
      background: linear-gradient(135deg, #ff5c8d, #111);
      padding: 20px;
    }

    .hero-content h2 {
      font-size: 2.8rem;
      margin-bottom: 20px;
      text-shadow: 1px 1px 5px #000;
    }

    .hero-content p {
      font-size: 1.2rem;
      margin-bottom: 30px;
    }

    .btn {
      background-color: #fff;
      color: #111;
      padding: 12px 25px;
      border-radius: 25px;
      font-weight: bold;
      cursor: pointer;
      text-decoration: none;
      transition: background-color 0.3s ease;
      border: none;
    }

    .btn:hover {
      background-color: #ff5c8d;
      color: #fff;
    }

    .products-section {
      padding: 80px 20px;
      max-width: 1200px;
      margin: 0 auto;
      text-align: center;
    }

    .product-list {
      display: flex;
      justify-content: center;
      flex-wrap: wrap;
      gap: 30px;
      margin-top: 40px;
    }

    .product-card {
      background-color: #222;
      padding: 20px;
      border-radius: 15px;
      width: 250px;
      box-shadow: 0 0 10px #ff5c8d88;
      text-align: center;
      transition: transform 0.3s ease;
    }

    .product-card:hover {
      transform: translateY(-5px);
    }

    .product-card img {
      width: 100%;
      height: 200px;
      object-fit: contain;
      margin-bottom: 15px;
    }

    .price {
      color: #ff5c8d;
      font-weight: bold;
      margin: 10px 0;
    }

    footer {
      text-align: center;
      padding: 20px;
      background-color: #111;
      color: #aaa;
      margin-top: 50px;
    }
  </style>
</head>
<body>

  <header class="header hidden" id="header">
    <h1 class="logo">Flover</h1>
    <nav class="nav-links">
      <a href="#hero" class="nav-btn">Accueil</a>
      <a href="#products" class="nav-btn">Produits</a>
      <!-- Bouton panier -->
      <button id="cart-bubble" aria-label="Voir le panier" title="Voir le panier">
        <i class="fa-solid fa-cart-shopping"></i>
        <span id="cart-count">0</span>
      </button>
    </nav>
  </header>

  <section class="hero-section" id="hero">
    <div class="hero-content">
      <h2>Bienvenue dans notre boutique en ligne</h2>
      <p>Découvrez les produits les plus tendances</p>
      <button class="btn" id="showHeaderBtn">Voir les produits <i class="fa-solid fa-arrow-down"></i></button>
    </div>
  </section>

  <main>
    <section id="products" class="products-section">
      <h2>Nos produits populaires</h2>
      <div class="product-list">
        <article class="product-card">
          <img src="image/iphone16.avif" alt="Iphone 16" loading="lazy" />
          <h3>Iphone 16</h3>
          <p class="price">€879.99</p>
          <button class="btn add-to-cart" data-name="Iphone 16" data-price="879.99">Ajouter au panier</button>
        </article>

        <article class="product-card">
          <img src="image/metaquest3.png" alt="Meta Quest 3" loading="lazy" />
          <h3>Meta Quest 3</h3>
          <p class="price">€549.99</p>
          <button class="btn add-to-cart" data-name="Meta Quest 3" data-price="549.99">Ajouter au panier</button>
        </article>

        <article class="product-card">
          <img src="image/Apple-Airpods-4-Blanc-avec-Boitier-de-charge-USB-C-Ecouteurs-sans-fil-removebg-preview.png" alt="AirPods 4ème génération" loading="lazy" />
          <h3>AirPods (4ᵉ génération)</h3>
          <p class="price">€299.99</p>
          <button class="btn add-to-cart" data-name="AirPods (4ᵉ génération)" data-price="299.99">Ajouter au panier</button>
        </article>
      </div>
    </section>
  </main>

  <div class="cart-panel" id="cart-panel">
    <p>Votre panier est vide.</p>
  </div>

  <footer>
    <p>&copy; 2025 Flover | Tous droits réservés</p>
  </footer>

  <script>
    const header = document.getElementById('header');
    const showHeaderBtn = document.getElementById('showHeaderBtn');

    // Au clic, afficher le header et scroller vers les produits
    showHeaderBtn.addEventListener('click', () => {
      header.classList.remove('hidden');
      document.getElementById('products').scrollIntoView({behavior: 'smooth'});
      // Ajuster padding-top du body pour header visible (80px)
      document.body.style.paddingTop = '80px';
    });

    // Panier
    const cartBubble = document.getElementById('cart-bubble');
    const cartCount = document.getElementById('cart-count');
    const cartPanel = document.getElementById('cart-panel');

    let cart = [];

    cartBubble.addEventListener('click', (e) => {
      e.stopPropagation();
      if (cartPanel.style.display === 'block') {
        cartPanel.style.display = 'none';
      } else {
        updateCartPanel();
        cartPanel.style.display = 'block';
      }
    });

    window.addEventListener('click', (e) => {
      if (!cartPanel.contains(e.target) && e.target !== cartBubble && !cartBubble.contains(e.target)) {
        cartPanel.style.display = 'none';
      }
    });

    const addToCartButtons = document.querySelectorAll('.add-to-cart');
    addToCartButtons.forEach(button => {
      button.addEventListener('click', () => {
        const name = button.dataset.name;
        const price = parseFloat(button.dataset.price);

        const existingProduct = cart.find(p => p.name === name);
        if (existingProduct) {
          existingProduct.quantity++;
        } else {
          cart.push({name, price, quantity: 1});
        }
        updateCartCount();
      });
    });

    function updateCartCount() {
      const totalQuantity = cart.reduce((sum, p) => sum + p.quantity, 0);
      cartCount.textContent = totalQuantity;
      if (totalQuantity === 0) {
        cartCount.style.display = 'none';
      } else {
        cartCount.style.display = 'inline-block';
      }
    }

    function updateCartPanel() {
      if (cart.length === 0) {
        cartPanel.innerHTML = '<p>Votre panier est vide.</p>';
        return;
      }
      let html = '<h4>Votre panier</h4><ul>';
      cart.forEach(item => {
        html += `<li>${item.name} x${item.quantity} - €${(item.price * item.quantity).toFixed(2)}</li>`;
      });
      html += '</ul>';
      const total = cart.reduce((sum, item) => sum + item.price * item.quantity, 0);
      html += `<p class="total">Total: €${total.toFixed(2)}</p>`;

      // Bouton Payer
      html += `<button id="pay-btn" style="
          background-color: #ff5c8d;
          color: white;
          border: none;
          padding: 10px 20px;
          border-radius: 25px;
          font-weight: bold;
          cursor: pointer;
          width: 100%;
          margin-top: 10px;
          box-shadow: 0 0 10px #ff5c8dbb;
          transition: background-color 0.3s ease;
        ">Payer</button>`;

      cartPanel.innerHTML = html;

      const payBtn = document.getElementById('pay-btn');
      payBtn.addEventListener('click', () => {
        window.location.href = 'payement.php';
      });
      payBtn.addEventListener('mouseenter', () => {
        payBtn.style.backgroundColor = '#e54d7a';
      });
      payBtn.addEventListener('mouseleave', () => {
        payBtn.style.backgroundColor = '#ff5c8d';
      });
    }

    updateCartCount();
  </script>
</body>
</html>
