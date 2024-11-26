// ]]]]]]7 nr6i76ifr563cfv1e2 f f           2q  q2                                                                                 1e1wsx67fd7qswasw bn
document.getElementById('searchForm').addEventListener('submit', function(e) {
    e.preventDefault();

    let query = document.getElementById('searchQuery').value;
    let color = document.getElementById('colorSelect').value;
    let size = document.getElementById('sizeSelect').value;

    fetch(`/search-products?query=${query}&color=${color}&size=${size}`)
        .then(response => response.json())
        .then(data => {
            let productList = document.getElementById('productList');
            productList.innerHTML = ''; // Xóa danh sách sản phẩm hiện tại

            data.forEach(variant => {
                let productItem = document.createElement('div');
                productItem.classList.add('product-item');
                productItem.innerHTML = `
                    <h5>${variant.product.name}</h5>
                    <p>Color: ${variant.color}</p>
                    <p>Size: ${variant.size}</p>
                    <p>Price: ${variant.price}</p>
                `;
                productList.appendChild(productItem);
            });
        });
});
