document.addEventListener("DOMContentLoaded", loadCart);

function addToCart(name, price, image) {
    let cart = JSON.parse(localStorage.getItem("cart")) || [];
    
    let item = cart.find(item => item.name === name);
    
    if (item) {
        item.quantity += 1;
    } else {
        cart.push({ name, price, image, quantity: 1 });
    }

    localStorage.setItem("cart", JSON.stringify(cart));
    updateCartCount();
    alert(name + " add to cart!");
}

function loadCart(){
    let cart = JSON.parse(localStorage.getItem("cart")) || [];
    document.getElementById("cart-count").textContent = cart.reduce((sum, item)=> sum + item.quantity, 0);
}

function clearCart(){
    localStorage.removeItem("cart");
    document.getElementById("cart-items").innerHTML = "";
    document.getElementById("cart-total").textContent = "0";
    updateCartCount();
}

function updateCartCount(){
    let cart = JSON.parse(localStorage.getItem("cart")) || [];
    document.getElementById("cart-count").textContent = cart.reduce((sum, item)=> sum + item.quantity, 0);
}