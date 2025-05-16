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
  <!-- Include Header -->
  <header class="navbar">
    <div class="navbar-left">
      <!-- Logo -->
      <a href="home.php" class="logo">
       <img src="image/logo.svg" alt="Cleckhudders Market Logo" />
      </a>
      <!-- Nav Links -->
      <ul class="nav-links">
        <li><a href="#">PRODUCT</a></li>
        <li><a href="Product_Catagory.php">SHOP</a></li>
        <li><a href="contact_us.php">CONTACT US</a></li>
      </ul>
    </div>
    <div class="navbar-right">
      <!-- Search Bar -->
      <div class="search-bar">
        <input type="text" placeholder="Search" />
        <button type="button" class="search-btn"><i class="fas fa-search"></i></button>
      </div>
      <a href="shopping_cart.php" class="cart-icon"><i class="fas fa-shopping-cart"></i></a>
      <?php if (isset($_SESSION['user_id'])): ?>
        <!-- User Profile Icon -->
        <div class="user-icon">
          <a href="User_Profile.php" class="user-icon">
            <i class="fas fa-user"></i> <!-- User icon -->
          </a>
          <a href="logout.php"><button>Logout</button></a>
        </div>
      <?php else: ?>
        <button onclick="location.href='user_selection.php'">Sign Up</button>
        <button onclick="location.href='login.php'">Log In</button>
      <?php endif; ?>
    </div>
  </header>