$(document).ready(function() {
            const productSelect = $('#id_product');
            const totalPriceInput = $('#total_price');
            const minQuantityInput = $('#minQuantity');

            productSelect.select2({
        placeholder: "Tìm kiếm sản phẩm...",
        language: {
            inputTooShort: function() {
                return 'Vui lòng nhập 3 hoặc nhiều ký tự';
            },
            searching: function() {
                return 'Đang tìm kiếm...';
            },
            noResults: function() {
                return 'Không tìm thấy kết quả phù hợp';
            }
        },
        allowClear: true,
        minimumInputLength: 3,
        ajax: {
            url: '/api/search-product',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return { query: params.term };
            },
            processResults: function(data) {
                return {
                    results: $.map(data, function(item) {
                        return { id: item.id, text: item.name };
                    })
                };
            },
            cache: true
        }
    });
    // Tính tổng giá và số lượng nhỏ nhất
    productSelect.on('change', function () {
        let totalPrice = 0;
        let minQuantity = null;

        // Lặp qua tất cả các sản phẩm đã chọn
        productSelect.find(':selected').each(function () {
            const price = parseFloat($(this).data('min-price')); // Lấy giá trị từ data-min-price
            const quantity = parseFloat($(this).data('min-quantity')); // Lấy giá trị từ data-min-quantity

            if (!isNaN(price)) {
                totalPrice += price; // Cộng giá sản phẩm
            }

            if (!isNaN(quantity)) {
                // Tìm số lượng nhỏ nhất
                if (minQuantity === null || quantity < minQuantity) {
                    minQuantity = quantity;
                }
            }
        });

        // Gán tổng giá và số lượng nhỏ nhất vào input
        totalPriceInput.val(totalPrice);
        minQuantityInput.val(minQuantity !== null ? minQuantity : 0); // Nếu không có sản phẩm nào, gán giá trị 0
    });
    
});

