$(document).ready(function() {
    $('#id_product').select2({
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
})