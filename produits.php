<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Flover - Boutique en ligne</title>
  <script src="https://kit.fontawesome.com/9f6048c82e.js" crossorigin="anonymous"></script>
  <style>
    body {
      margin: 0;
      font-family: "Poppins", sans-serif;
      background-color: #111;
      color: #fff;
    }

    .header {
      background-color: #1a1a1a;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 15px 30px;
      box-shadow: 0 0 15px #ff5c8d66;
    }

    .logo {
      font-size: 28px;
      color: #ff5c8d;
      text-shadow: 0 0 8px #ff5c8d88;
    }

    .nav-links {
      display: flex;
      gap: 20px;
    }

    .nav-btn {
      color: #fff;
      text-decoration: none;
      padding: 8px 15px;
      border-radius: 20px;
      transition: background-color 0.3s ease;
    }

    .nav-btn:hover {
      background-color: #ff5c8d;
      color: #fff;
    }

    .cart-bubble {
      background-color: #ff5c8d;
      border: none;
      border-radius: 50%;
      padding: 10px;
      cursor: pointer;
      color: #fff;
      font-size: 18px;
      position: relative;
      transition: transform 0.2s ease;
      box-shadow: 0 0 12px #ff5c8d88;
    }

    .cart-bubble:hover {
      transform: scale(1.1);
    }

    #cart-count {
      position: absolute;
      top: -5px;
      right: -5px;
      background-color: #fff;
      color: #ff5c8d;
      border-radius: 50%;
      padding: 2px 6px;
      font-size: 12px;
      font-weight: bold;
    }

    main {
      padding: 40px 20px;
    }

    .products-section {
      max-width: 1200px;
      margin: 0 auto;
      text-align: center;
    }

    .products-section h2 {
      color: #ff5c8d;
      margin-bottom: 30px;
      font-size: 32px;
      text-shadow: 0 0 8px #ff5c8d88;
    }

    .product-list {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
      gap: 30px;
      animation: slideUp 0.6s ease forwards;
    }

    @keyframes slideUp {
      from { transform: translateY(30px); opacity: 0; }
      to { transform: translateY(0); opacity: 1; }
    }

    .product-card {
      background-color: #1a1a1a;
      padding: 20px;
      border-radius: 15px;
      box-shadow: 0 0 15px #ff5c8d22;
      display: flex;
      flex-direction: column;
      align-items: center;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .product-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 0 20px #ff5c8d55;
    }

    .product-card img {
      max-width: 100%;
      height: auto;
      margin-bottom: 15px;
      border-radius: 10px;
    }

    .product-card h3 {
      margin: 10px 0 5px;
      color: #fff;
    }

    .price {
      color: #ff5c8d;
      font-size: 18px;
      margin-bottom: 15px;
    }

    .add-to-cart {
      background-color: #ff5c8d;
      color: #fff;
      border: none;
      padding: 10px 20px;
      border-radius: 25px;
      cursor: pointer;
      font-weight: bold;
      transition: background-color 0.3s ease, transform 0.2s ease;
      box-shadow: 0 0 12px #ff5c8d88;
    }

    .add-to-cart:hover {
      background-color: #e54d7a;
      transform: translateY(-2px);
    }

    footer {
      text-align: center;
      padding: 20px;
      background-color: #1a1a1a;
      color: #777;
      margin-top: 40px;
    }
  </style>
</head>
<body>
    
  <header class="header">
    <h1 class="logo">Flover</h1>

    <nav class="nav-links">
      <a href="#hero" class="nav-btn">Accueil</a>
      <a href="#products" class="nav-btn">Produits</a>
      <a href="#contact" class="nav-btn">Contact</a>
    </nav>

    <button id="cart-bubble" aria-label="Voir le panier" title="Voir le panier" class="cart-bubble">
      <i class="fa-solid fa-cart-shopping"></i>
      <span id="cart-count">0</span>
    </button>
  </header>

  <main>
    <section id="products" class="products-section">
      <h2>Nos produits populaires</h2>
      <div class="product-list">
        <article class="product-card">
          <img src="image/iphone16.avif" alt="Iphone 16" loading="lazy" />
          <h3>Iphone 16</h3>
          <p class="price">€879.99</p>
          <button class="add-to-cart">Ajouter au panier</button>
        </article>
        <article class="product-card">
          <img src="image/metaquest3.png" alt="Meta Quest 3" loading="lazy" />
          <h3>Meta Quest 3</h3>
          <p class="price">€549.99</p>
          <button class="add-to-cart">Ajouter au panier</button>
        </article>
        <article class="product-card">
          <img src="image/Apple-Airpods-4-Blanc-avec-Boitier-de-charge-USB-C-Ecouteurs-sans-fil-removebg-preview.png" alt="AirPods 4ème génération" loading="lazy" />
          <h3>AirPods (4ᵉ génération)</h3>
          <p class="price">€299.99</p>
          <button class="add-to-cart">Ajouter au panier</button>
        </article>
        <article class="product-card">
          <img src="image/pc.png" alt="Pc Gamer" loading="lazy" />
          <h3>Pc Gamer</h3>
          <p class="price">€2999.99</p>
          <button class="add-to-cart">Ajouter au panier</button>
        </article>
      </div>
    </section>
  </main>

  <footer>
    <p>&copy; 2025 Flover | Tous droits réservés</p>
  </footer>

  <script>
    // Fonction pour mettre à jour le compteur du panier
    function updateCartCount() {
      const count = localStorage.getItem("cartCount") || 0;
      document.getElementById("cart-count").textContent = count;
    }

    // Initialisation au chargement
    updateCartCount();

    // Ajout des événements sur tous les boutons "Ajouter au panier"
    const addToCartButtons = document.querySelectorAll(".add-to-cart");
    addToCartButtons.forEach(btn => {
      btn.addEventListener("click", () => {
        let count = parseInt(localStorage.getItem("cartCount")) || 0;
        count++;
        localStorage.setItem("cartCount", count);
        updateCartCount();
      });
    });
  </script>
</body>
</html>
