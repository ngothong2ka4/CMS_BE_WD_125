@extends('layouts.app-theme')


@section('content')
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            @php
                toastr()->error($error)
            @endphp
        @endforeach
    @endif
    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-1">
                <div class="card-header" style="background: transparent !important;">
                    <h2 class="mb-0">Thêm mới sản phẩm</h2>
                </div>
            </div>
            
            <form action="{{ route('product_color.store') }}" method="POST">
                @csrf
                <div class="card mb-2">
                    <div class="card-header">
                        <h4 class="mb-0">Thông tin chung</h4>
                    </div>
                    <div class="card-body">
                        <div>
                            <label for="basiInput" class="form-label">Tên sản phẩm</label>
                            <input type="text" class="form-control" id="basiInput" name="name">
                        </div>
                        <div>
                            <label for="basiInput" class="form-label">Mã sản phẩm</label>
                            <input type="text" class="form-control" id="basiInput" name="name">
                        </div>
                        <div>
                            <label for="basiInput" class="form-label">Danh mục</label>
                            <select class="form-select mb-3" aria-label="Default select example">
                                <option selected>Open this select menu</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                            </select>
                        </div>
                        <div>
                            <label for="basiInput" class="form-label">Chất liệu</label>
                            <select class="form-select mb-3" aria-label="Default select example">
                                <option selected>Open this select menu</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                            </select>
                        </div>
                        <div>
                            <label for="basiInput" class="form-label">Đá</label>
                            <select class="form-select mb-3" aria-label="Default select example">
                                <option selected>Open this select menu</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                            </select>
                        </div>
                        <div>
                            <label for="basiInput" class="form-label">Mô tả</label>
                            <textarea class="form-control" id="meassageInput" rows="3" placeholder="Nhập mô tả"></textarea>
                        </div>
                    </div>
                </div>
                <div class="card mt-2">
                    <div class="card-header">
                        <h4 class="mb-0">Biến thể</h4>
                    </div>
                    <div class="card-body">
                        <div id="variant-container">
                            <div class="form-group d-flex" id="variant-0">
                                <div class="form-group me-1">
                                    <label for="color-0" class="form-label">Màu sắc</label>
                                    <select class="form-select mb-3" id="color-0" name="colors[]" aria-label="Default select example">
                                        <option selected>Chọn màu sắc</option>
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                                </div>
                                <div class="form-group me-1">
                                    <label for="size-0" class="form-label">Kích thước</label>
                                    <select class="form-select mb-3" id="size-0" name="sizes[]" aria-label="Default select example">
                                        <option selected>Chọn kích thước</option>
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                                </div>
                                <div class="me-1">
                                    <label for="price_in-0" class="form-label">Giá nhập</label>
                                    <input type="text" class="form-control" id="price_in-0" name="price_in[]" placeholder="Nhập giá nhập">
                                </div>
                                <div class="me-1">
                                    <label for="price_out-0" class="form-label">Giá niêm yết</label>
                                    <input type="text" class="form-control" id="price_out-0" name="price_out[]" placeholder="Nhập giá niêm yết">
                                </div>
                                <div class="me-1">
                                    <label for="sale_price-0" class="form-label">Giá bán</label>
                                    <input type="text" class="form-control" id="sale_price-0" name="sale_price[]" placeholder="Nhập giá bán">
                                </div>
                                <div class="me-1">
                                    <label for="quantity-0" class="form-label">Số lượng</label>
                                    <input type="number" class="form-control" id="quantity-0" name="quantity[]" placeholder="Nhập số lượng">
                                </div>
                                <div style="margin-top: 27px">
                                    <button class="btn btn-danger remove-variant-btn" data-variant-id="variant-0" type="button">Xoá</button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <button type="button" class="btn btn-outline-info" id="add-variant-btn">Thêm biến thể</button>
                        </div>
                    </div>
                    <div class="mt-3 ms-auto me-auto mb-2">
                        <button class="btn btn-success" type="submit">Thêm mới</button>
                    </div>
                </div>
            </form>
        </div><!--end col-->
    </div>
@endsection

@push('scripts')
    <script>
        let variantCounter = 1;

        $('#add-variant-btn').click(function() {
            variantCounter++;

            let newVariant = `
                <div class="form-group d-flex" id="variant-${variantCounter}">
                    <div class="form-group me-1">
                        <label for="color-${variantCounter}" class="form-label">Màu sắc</label>
                        <select class="form-select mb-3" id="color-${variantCounter}" name="colors[]" aria-label="Default select example">
                            <option selected>Chọn màu sắc</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                    </div>
                    <div class="form-group me-1">
                        <label for="size-${variantCounter}" class="form-label">Kích thước</label>
                        <select class="form-select mb-3" id="size-${variantCounter}" name="sizes[]" aria-label="Default select example">
                            <option selected>Chọn kích thước</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                    </div>
                    <div class="me-1">
                        <label for="price_in-${variantCounter}" class="form-label">Giá nhập</label>
                        <input type="text" class="form-control" id="price_in-${variantCounter}" name="price_in[]" placeholder="Nhập giá nhập">
                    </div>
                    <div class="me-1">
                        <label for="price_out-${variantCounter}" class="form-label">Giá niêm yết</label>
                        <input type="text" class="form-control" id="price_out-${variantCounter}" name="price_out[]" placeholder="Nhập giá niêm yết">
                    </div>
                    <div class="me-1">
                        <label for="sale_price-${variantCounter}" class="form-label">Giá bán</label>
                        <input type="text" class="form-control" id="sale_price-${variantCounter}" name="sale_price[]" placeholder="Nhập giá bán">
                    </div>
                    <div class="me-1">
                        <label for="quantity-${variantCounter}" class="form-label">Số lượng</label>
                        <input type="number" class="form-control" id="quantity-${variantCounter}" name="quantity[]" placeholder="Nhập số lượng">
                    </div>
                    <div style="margin-top: 27px">
                        <button class="btn btn-danger remove-variant-btn" data-variant-id="variant-${variantCounter}" type="button">Xoá</button>
                    </div>
                </div>
            `;

            $('#variant-container').append(newVariant);
        });

        $(document).on('click', '.remove-variant-btn', function() {
            let totalVariants = $('#variant-container .form-group.d-flex').length;
            console.log(totalVariants);
            
            if (totalVariants > 1) {
                let variantId = $(this).data('variant-id'); 
                $('#' + variantId).remove(); 
            } 
        });

    </script>
@endpush
