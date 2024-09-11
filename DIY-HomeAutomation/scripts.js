document.addEventListener('DOMContentLoaded', () => {
    loadProducts();

    if (window.location.pathname.includes('ecommerce.html')) {
        loadProducts();
    }
});

function loadProducts() {
    const productList = document.getElementById('product-list');

    if (productList) {
        fetch('get_products.php')
            .then(response => response.json())
            .then(data => {
                data.forEach(product => {
                    const productDiv = document.createElement('div');
                    productDiv.innerHTML = `
                        <h3>${product.name}</h3>
                        <p>Price: $${product.price}</p>
                        <button onclick="addToCart(${product.id})">Add to Cart</button>
                    `;
                    productList.appendChild(productDiv);
                });
            });
    }
}

function addToCart(productId) {
    fetch('add_to_cart.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ productId }),
    })
    .then(response => response.text())
    .then(data => {
        alert(data);
    });
}



document.addEventListener('DOMContentLoaded', () => {
    loadProducts();

    if (window.location.pathname.includes('ecommerce.html')) {
        loadProducts();
    }
});

function loadProducts() {
    const productList = document.getElementById('product-list');

    if (productList) {
        fetch('get_products.php')
            .then(response => response.json())
            .then(data => {
                data.forEach(product => {
                    const productDiv = document.createElement('div');
                    productDiv.innerHTML = `
                        <img src="${product.image}" alt="${product.name}" width="150" height="150">
                        <h3>${product.name}</h3>
                        <p>Price: $${product.price}</p>
                        <button onclick="addToCart(${product.id})">Add to Cart</button>
                    `;
                    productList.appendChild(productDiv);
                });
            });
    }
}

function addToCart(productId) {
    fetch('add_to_cart.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ productId }),
    })
    .then(response => response.text())
    .then(data => {
        alert(data);
    });
}
