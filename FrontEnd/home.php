<?php
session_start();
include "header.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>Landing page</title>
  <!-- Google Font: Rubik (Example) -->
  <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;500;600&display=swap" rel="stylesheet" />
  <!-- Link to external CSS -->
  <link rel="stylesheet" href="homestyle.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
  <!-- Hero Section -->
  <section class="hero">
    <div class="hero-overlay">
      <div class="hero-section">
        <div class="hero-text">
          <h1>Too Busy to Shop?<br>Let Us Deliver to Your Door!</h1>
          <p>Enjoy quality shopping from your favourite local traders. Order now and collect your order at our convenient pickup point.</p>
          <a href="#" class="shop-btn">SHOP NOW</a>
        </div>
        <div class="hero-image">
          <img src="image/bag_cutout.png" alt="Groceries Bag">
        </div>
      </div>
    </div>
  </section>

  <!-- featured product section -->
  <section class="shop-section">
    <h2 class="title">SHOP BY TYPE</h2>
    <div class="card-container">
      <div class="card">
        <img src="image/meat.png" alt="Meats">
        <div class="label">MEATS</div>
      </div>
      <div class="card">
        <img src="image/fish.avif" alt="Fish">
        <div class="label">FISH</div>
      </div>
      <div class="card">
        <img src="image/green.avif" alt="Greens">
        <div class="label">GREENS</div>
      </div>
      <div class="card">
        <img src="image/baked.avif" alt="Baked">
        <div class="label">BAKED</div>
      </div>
      <div class="card">
        <img src="image/delicatessen.avif" alt="Delicatessen">
        <div class="label">DELICATESSEN</div>
      </div>
    </div>
  </section>

  <!-- recomended items -->
  <section class="recommended-section">
    <h2 class="title">RECOMMENDED</h2>
    <div class="grid-container">
      <!-- Product Card (Repeat for multiple products) -->
      <div class="card">
        <img src="image/meat.png" alt="Product Image">
        <div class="card-content">
          <h3>Product Name</h3>
          <p class="rating">★★★★★</p>
          <p><span class="shop-name">By: Shop Name</span></p>
          <p class="price">Price</p>
          <button class="add-to-cart"> View Product</button>
        </div>
      </div>

      <div class="card">
        <img src="image/meat.png" alt="Product Image">
        <div class="card-content">
          <h3>Product Name</h3>
          <p class="rating">★★★★★</p>
          <p><span class="shop-name">By: Shop Name</span></p>
          <p class="price">Price</p>
          <button class="add-to-cart"> View Product</button>
        </div>
      </div>

      <div class="card">
        <img src="image/meat.png" alt="Product Image">
        <div class="card-content">
          <h3>Product Name</h3>
          <p class="rating">★★★★★</p>
          <p><span class="shop-name">By: Shop Name</span></p>
          <p class="price">Price</p>
          <button class="add-to-cart"> View Product</button>
        </div>
      </div>

      <div class="card">
        <img src="image/meat.png" alt="Product Image">
        <div class="card-content">
          <h3>Product Name</h3>
          <p class="rating">★★★★★</p>
          <p><span class="shop-name">By: Shop Name</span></p>
          <p class="price">Price</p>
          <button class="add-to-cart"> View Product</button>
        </div>
      </div>

      <div class="card">
        <img src="image/meat.png" alt="Product Image">
        <div class="card-content">
          <h3>Product Name</h3>
          <p class="rating">★★★★★</p>
          <p><span class="shop-name">By: Shop Name</span></p>
          <p class="price">Price</p>
          <button class="add-to-cart"> View Product</button>
        </div>
      </div>
    </div>

    <div class="grid-container">
      <!-- Product Card (Repeat for multiple products) -->
      <div class="card">
        <img src="image/meat.png" alt="Product Image">
        <div class="card-content">
          <h3>Product Name</h3>
          <p class="rating">★★★★★</p>
          <p><span class="shop-name">By: Shop Name</span></p>
          <p class="price">Price</p>
          <button class="add-to-cart"> View Product</button>
        </div>
      </div>

      <div class="card">
        <img src="image/meat.png" alt="Product Image">
        <div class="card-content">
          <h3>Product Name</h3>
          <p class="rating">★★★★★</p>
          <p><span class="shop-name">By: Shop Name</span></p>
          <p class="price">Price</p>
          <button class="add-to-cart"> View Product</button>
        </div>
      </div>

      <div class="card">
        <img src="image/meat.png" alt="Product Image">
        <div class="card-content">
          <h3>Product Name</h3>
          <p class="rating">★★★★★</p>
          <p><span class="shop-name">By: Shop Name</span></p>
          <p class="price">Price</p>
          <button class="add-to-cart"> View Product</button>
        </div>
      </div>

      <div class="card">
        <img src="image/meat.png" alt="Product Image">
        <div class="card-content">
          <h3>Product Name</h3>
          <p class="rating">★★★★★</p>
          <p><span class="shop-name">By: Shop Name</span></p>
          <p class="price">Price</p>
          <button class="add-to-cart"> View Product</button>
        </div>
      </div>

      <div class="card">
        <img src="image/meat.png" alt="Product Image">
        <div class="card-content">
          <h3>Product Name</h3>
          <p class="rating">★★★★★</p>
          <p><span class="shop-name">By: Shop Name</span></p>
          <p class="price">Price</p>
          <button class="add-to-cart"> View Product</button>
        </div>
      </div>
    </div>

  </section>


  <!-- best deals -->

  <section class="deals-section">
    <h2 class="section-title">BEST DEALS</h2>
    <?php include "product_list.php";?>
    <div class="product-grid">
      <!-- Product Card -->
      <div class="product-card">
        <img src="image/meat.png" alt="Product Image">
        <div class="product-info">
          <h3>Product Name</h3>
          <p class="stars">★★★★★</p>
          <p>By: <span class="shop-name">Shop Name</span></p>
          <p><strong>Price</strong></p>
          <p>Qty <input type="number" value="1" min="1" max="99"></p>
        </div>
        <button class="add-to-cart">Add to Cart</button>
      </div>

      <div class="product-card">
        <img src="image/meat.png" alt="Product Image">
        <div class="product-info">
          <h3>Product Name</h3>
          <p class="stars">★★★★★</p>
          <p>By: <span class="shop-name">Shop Name</span></p>
          <p><strong>Price</strong></p>
          <p>Qty <input type="number" value="1" min="1" max="99"></p>
        </div>
        <button class="add-to-cart">Add to Cart</button>
      </div>

      <div class="product-card">
        <img src="image/meat.png" alt="Product Image">
        <div class="product-info">
          <h3>Product Name</h3>
          <p class="stars">★★★★★</p>
          <p>By: <span class="shop-name">Shop Name</span></p>
          <p><strong>Price</strong></p>
          <p>Qty <input type="number" value="1" min="1" max="99"></p>
        </div>
        <button class="add-to-cart">Add to Cart</button>
      </div>

      <div class="product-card">
        <img src="image/meat.png" alt="Product Image">
        <div class="product-info">
          <h3>Product Name</h3>
          <p class="stars">★★★★★</p>
          <p>By: <span class="shop-name">Shop Name</span></p>
          <p><strong>Price</strong></p>
          <p>Qty <input type="number" value="1" min="1" max="99"></p>
        </div>
        <button class="add-to-cart">Add to Cart</button>
      </div>

      <div class="product-card">
        <img src="image/meat.png" alt="Product Image">
        <div class="product-info">
          <h3>Product Name</h3>
          <p class="stars">★★★★★</p>
          <p>By: <span class="shop-name">Shop Name</span></p>
          <p><strong>Price</strong></p>
          <p>Qty <input type="number" value="1" min="1" max="99"></p>
        </div>
        <button class="add-to-cart">Add to Cart</button>
      </div>
    </div>
  </section>

  <!-- FOOTER -->
  <?php
    include "footer.php";
  ?>
</body>