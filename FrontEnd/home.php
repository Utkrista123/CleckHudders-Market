<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar</title>
    <link rel="stylesheet" href="Style- home.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
</head>
<body class="showCart">
    <nav class="navbar">
        <div class="nav-links">
            <a href="#">Shop</a>
            <a href="#">Services</a>
            <a href="#">About us</a>
            <a href="#">Contact us</a>
        </div>
        <div class="logo">Logo</div>
        <div class="auth-icons">
            <div class="auth-buttons">
                <button>Sign in</button>
                <button>Log in</button>
            </div>
            <div class="icons">
                <input type="text" placeholder="Search Product" class="search">
                <div style="position: relative; display: inline-block;">
                    <i class="fa-solid fa-cart-shopping"></i>
                    <span id="cart-count">0</span> <!-- Cart Badge -->
                </div>
            </div>
        </div>
    </nav>

    <div class="images">
        <img src="image\groceries-1343141_640.jpg" alt="" class="image1">
    </div>

<div class="product-container">
    <div class="container">
        <div class="title">NEW ARRIVAL</div>
        <div class="title-underline"></div>
        <div class="products">
            <div class="product">
                <img src="image/360_F_236881295_odo9H1vtTZUvewumPdeRE4tHUtVa2UJg.jpg" alt="Product Image">
                <div class="name">Fresh Mustang Apple | 1Kg</div>
                <div class="price">Rs.250</div>
                <button onclick="addToCart('Fresh Mustang Apple', 250, 'image/360_F_236881295_odo9H1vtTZUvewumPdeRE4tHUtVa2UJg.jpg')">
                    ADD TO CART
                </button>                
            </div>
            <div class="product">
                <img src="placeholder.png" alt="Product Image">
                <div class="name">Name</div>
                <div class="price">Price</div>
                <button>ADD TO CART</button>
            </div>
            <div class="product">
                <img src="placeholder.png" alt="Product Image">
                <div class="name">Name</div>
                <div class="price">Price</div>
                <button>ADD TO CART</button>
            </div>
            <div class="product">
                <img src="placeholder.png" alt="Product Image">
                <div class="name">Name</div>
                <div class="price">Price</div>
                <button>ADD TO CART</button>
            </div>
            <div class="product">
                <img src="placeholder.png" alt="Product Image">
                <div class="name">Name</div>
                <div class="price">Price</div>
                <button>ADD TO CART</button>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="title">TOP SELLING</div>
        <div class="title-underline"></div>
        <div class="products">
            <div class="product">
                <img src="image/360_F_236881295_odo9H1vtTZUvewumPdeRE4tHUtVa2UJg.jpg" alt="Product Image">
                <div class="name">Name</div>
                <div class="price">Price</div>
                <button>ADD TO CART</button>
            </div>
            <div class="product">
                <img src="placeholder.png" alt="Product Image">
                <div class="name">Name</div>
                <div class="price">Price</div>
                <button>ADD TO CART</button>
            </div>
            <div class="product">
                <img src="placeholder.png" alt="Product Image">
                <div class="name">Name</div>
                <div class="price">Price</div>
                <button>ADD TO CART</button>
            </div>
            <div class="product">
                <img src="placeholder.png" alt="Product Image">
                <div class="name">Name</div>
                <div class="price">Price</div>
                <button>ADD TO CART</button>
            </div>
            <div class="product">
                <img src="placeholder.png" alt="Product Image">
                <div class="name">Name</div>
                <div class="price">Price</div>
                <button>ADD TO CART</button>
            </div>
        </div>
    </div>
</div>

    <div class="cartTab">
        <h1>Shopping Cart</h1>
        <div class="listCart">
            <div class="item">
                <div class="image">
                    <img src="image/360_F_236881295_odo9H1vtTZUvewumPdeRE4tHUtVa2UJg.jpg" alt="">
                </div>
                <div class="name">
                    NAME
                </div>
                <div class="totalPrice">
                    RS.200
                </div>
                <div class="quantity">
                    <span class="minus">-</span>
                    <span>1</span>
                    <span class="plus">+</span>
                </div>
            </div>
            
        </div>
        <div class="btn">
            <button class="close">CLOSE</button>
            <button class="checkOut">CHECK OUT</button>
        </div>
    </div>

    <div class="footer-section">
        <div class="footer-background"></div>
        <div class="footer-content">
            <div class="footer-left">
                <h2 class="footer-title">CLECKHUDDERS MARKET</h2>
            </div>
            
            <div class="footer-middle">
                <div class="company-section">
                    <h3>CLECKHUDDERS MARKET</h3>
                    <div class="contact-info">
                        Phone: +977 9874561230<br>
                        Email: checkhudderes@gmail.com<br>
                        Address:Thapathali, Trade Tower
                    </div>
                    <div class="social-icons">
                        <a href="#" class="social-icon">
                            <i class="fa-brands fa-facebook"></i>
                        </a>
                        <a href="#" class="social-icon">
                            <i class="fa-brands fa-facebook-messenger"></i>
                        </a>
                        <a href="#" class="social-icon">
                            <i class="fa-brands fa-square-instagram"></i>
                        </a>
                        <a href="#" class="social-icon">
                            <i><i class="fa-brands fa-x-twitter"></i></i>
                        </a>
                        <a href="#" class="social-icon">
                            <i class="fa-brands fa-google"></i>
                        </a>
                        <a href="#" class="social-icon">
                            <i class="fa-brands fa-youtube"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="footer-right">
                <div class="company-section">
                    <h3>RECENT NEWS</h3>
                    <div class="footer-links">
                        <a href="#">About Us</a>
                        <a href="#">Services</a>
                        <a href="#">Get In Touch</a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="footer-bottom">
            <div class="copyright">© Copyright 2025 CLECKHUDDERS MARKET - All Rights Reserved</div>
        </div>
    </div>
    <script src="cart.js"></script>
</body>
</html>

