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
    function updateComboDetails() {
        let totalPrice = 0; // Khởi tạo tổng giá
        let minQuantity = null; // Khởi tạo số lượng nhỏ nhất

        // Lặp qua các sản phẩm đã chọn
        productSelect.find('option:selected').each(function () {
            const price = parseFloat($(this).attr('data-min-price')); // Giá sản phẩm
            const quantity = parseFloat($(this).attr('data-min-quantity')); // Số lượng sản phẩm

            if (!isNaN(price)) {
                totalPrice += price; // Tính tổng giá
            }

            if (!isNaN(quantity)) {
                // Tìm số lượng nhỏ nhất
                if (minQuantity === null || quantity < minQuantity) {
                    minQuantity = quantity;
                }
            }
        });

        // Gán giá trị vào input
        totalPriceInput.val(totalPrice.toFixed(2)); // Tổng giá (định dạng 2 số thập phân)
        minQuantityInput.val(minQuantity !== null ? minQuantity : 0); // Số lượng nhỏ nhất (nếu không có, gán 0)
    }

    // Tính toán ngay khi trang load (xem chi tiết combo)
    updateComboDetails();

    // Tính toán lại khi có thay đổi (nếu giao diện cho phép chỉnh sửa sản phẩm)
    productSelect.on('change', updateComboDetails);
    
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

