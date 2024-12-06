$(document).ready(function() {
    // $('#id_product').select2({
    //     placeholder: "Tìm kiếm sản phẩm...",
    //     language: {
    //         inputTooShort: function() {
    //             return 'Vui lòng nhập 3 hoặc nhiều ký tự';
    //         },
    //         searching: function() {
    //             return 'Đang tìm kiếm...';
    //         },
    //         noResults: function() {
    //             return 'Không tìm thấy kết quả phù hợp';
    //         }
    //     },
    //     allowClear: true,
    //     minimumInputLength: 3,
    //     ajax: {
    //         url: '/api/search-product',
    //         dataType: 'json',
    //         delay: 250,
    //         data: function(params) {
    //             return { query: params.term };
    //         },
    //         processResults: function(data) {
    //             return {
    //                 results: $.map(data, function(item) {
    //                     return { id: item.id, text: item.name };
    //                 })
    //             };
    //         },
    //         cache: true
    //     }
    // });

    $('#id_user').select2({
        placeholder: "Tìm kiếm người dùng...",
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
            url: '/api/search-user',
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
});

function toggleDiscountFields() {
    const discountType = document.getElementById('discount_type').value;
    const percentageDiscount = document.getElementById('percentageDiscount');

    if (discountType == 1) {
        percentageDiscount.style.display = 'block';
    } else {
        percentageDiscount.style.display = 'none';
    }
}

function toggleFields() {
    const userVoucherLimit = document.getElementById('user_voucher_limit').value;
    const conditionalFields = document.getElementById('conditionalFields');
    const conditionalUserField = document.getElementById('conditionalUserField');

    if (userVoucherLimit == 2) {
        conditionalFields.style.display = 'block';
        conditionalUserField.style.display = 'none';
    } else if (userVoucherLimit == 3) {
        conditionalFields.style.display = 'none';
        conditionalUserField.style.display = 'block';
    } else {
        conditionalFields.style.display = 'none';
        conditionalUserField.style.display = 'none';
    }
}
