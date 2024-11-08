@extends('layouts.app-theme')


@section('content')
@if ($errors->any())
@foreach ($errors->all() as $error)
@php
toastr()->error($error);
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

        <form action="{{ route('product_management.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card mb-2">
                <div class="card-header">
                    <h4 class="mb-0">Thông tin chung</h4>
                </div>
                <div class="card-body">
                    <div>
                        <label for="basiInput" class="form-label">Tên sản phẩm</label>
                        <input type="text" class="form-control mb-3" id="basiInput" name="name"
                            value="{{ old('name') }}">
                        @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div>
                        <label for="basiInput" class="form-label">Danh mục sản phẩm</label>
                        <select name="id_category" class="form-select mb-3" aria-label="Default select example">
                            <option value="">Chọn danh mục</option>
                            @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ old('id_category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('id_category')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div>
                        <label for="basiInput" class="form-label">Chất liệu sản phẩm</label>
                        <select name="id_materials" class="form-select mb-3" aria-label="Default select example">
                            <option value="">Chọn chất liệu</option>
                            @foreach ($materials as $material)
                            <option value="{{ $material->id }}"
                                {{ old('id_materials') == $material->id ? 'selected ' : ' ' }}>
                                {{ $material->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('id_materials')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div>
                        <label for="basiInput" class="form-label">Đá</label>
                        <select name="id_stones" class="form-select mb-3" aria-label="Default select example">
                            <option value="">Chọn đá</option>
                            @foreach ($stones as $stone)
                            <option value="{{ $stone->id }}"
                                {{ old('id_stones') == $stone->id ? 'selected' : '' }}>{{ $stone->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('id_stones')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div>
                        <label for="basiInput" class="form-label">Hình ảnh</label>
                        <input type="file" name="thumbnail" id="" class="form-control mb-3">
                        @error('thumbnail')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div>
                        <label for="basiInput" class="form-label">Mô tả</label>
                        <textarea class="form-control mb-3" name="description" id="meassageInput" rows="3" placeholder="Nhập mô tả">{{ old('description') }}</textarea>
                    </div>
                    <div>
                        <label for="basiInput" class="form-label">Hình ảnh cho slide(chọn nhiều ảnh)</label>
                        <input accept="image/x-png,image/gif,image/jpeg" type="file" name="link_image[]" multiple
                            id="" class="form-control mb-3">
                        @error('thumbnail')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="card mt-2">
                <div class="card-header">
                    <h4 class="mb-0">Danh sách biến thể</h4>
                </div>
                <div class="card-body">
                    <div id="variant-container">
                        @if(old('id_attribute_color'))
                        @foreach(old('id_attribute_color') as $key => $value)
                        <div class="form-group d-flex variant-row" id="variant-{{$key + 1}}">
                            <div class="form-group me-1">
                                <label for="color-{{$key + 1}} " class="form-label">Màu sắc</label>
                                <select required name="id_attribute_color[]" class="form-select mb-3 variant-select color-select " id="color-{{$key + 1}}" aria-label="Default select example">
                                    <option value="">Chọn màu sắc</option>
                                    @foreach ($colors as $color)
                                    <option value="{{ $color->id }}"
                                        {{ $value == $color->id ? 'selected' : '' }}>{{ $color->name }} </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group me-1">
                                <label for="size-{{$key + 1}}" class="form-label">Kích thước</label>
                                <select name="id_attribute_size[]" class="form-select mb-3 variant-select size-select " id="size-{{$key + 1}}" aria-label="Default select example">
                                    <option value="">Chọn kích thước</option>
                                    @foreach ($sizes as $size)
                                    <option value="{{ $size->id }}"
                                        {{ old('id_attribute_size')[$key] == $size->id ? 'selected' : '' }}>{{ $size->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="me-1">
                                <label for="price_in-{{$key + 1}}" class="form-label">Giá nhập</label>
                                <input name="import_price[]" value="{{old('import_price')[$key]}}" type="number" required min=0 class="form-control price-validate price_in" id="price_in-{{$key + 1}}" placeholder="Nhập giá nhập">
                            </div>
                            <div class="me-1">
                                <label for="price_out-{{$key + 1}}" class="form-label">Giá niêm yết</label>
                                <input name="list_price[]" value="{{old('list_price')[$key]}}" type="number" required min=0 class="form-control price-validate price_out" id="price_out-{{$key + 1}}" placeholder="Nhập giá niêm yết">
                            </div>
                            <div class="me-1">
                                <label for="sale_price-{{$key + 1}}" class="form-label">Giá bán</label>
                                <input name="selling_price[]" value="{{old('selling_price')[$key]}}" type="number" required min=0 class="form-control price-validate sale_price" id="sale_price-{{$key + 1}}" placeholder="Nhập giá bán">
                            </div>
                            <div class="me-1">
                                <label for="quantity-{{$key + 1}}" class="form-label">Số lượng</label>
                                <input name="quantity[]" value="{{old('quantity')[$key]}}" type="number" required min=0 class="form-control" id="quantity-{{$key + 1}}" placeholder="Nhập số lượng">
                            </div>
                            <div class="me-1">
                                <label for="image_color-{{$key + 1}}" class="form-label">Ảnh</label>
                                <input name="image_color[]" type="file" min=0 class="form-control" id="image_color-{{$key + 1}}" placeholder="Nhập ảnh">
                            </div>
                            <div style="margin-top: 27px">
                                <button class="btn btn-danger remove-variant-btn" data-variant-id="variant-{{$key + 1}}" type="button">Xoá</button>
                            </div>
                        </div>
                        @endforeach
                        @endif
                    </div>

                    <div class="form-group">
                        <button type="button" class="btn btn-outline-info" id="add-variant-btn">Thêm biến
                            thể</button>
                    </div>
                </div>
                <div class="mt-3 ms-auto me-auto mb-2">
                    <button class="btn btn-success" type="submit">Thêm mới</button>
                </div>
            </div>
        </form>
    </div><!--end col-->
</div>

<script>
    <?php $count = old('id_attribute_color') ? count(old('id_attribute_color')) + 1 : 1; ?>
    let variantCounter = <?= $count; ?>;
    console.log(variantCounter)

    $('#add-variant-btn').click(function() {
        variantCounter++;

        let newVariant = `
                <div class="form-group d-flex variant-row" id="variant-${variantCounter}">
                    <div class="form-group me-1">
                        <label for="color-${variantCounter} " class="form-label">Màu sắc</label>
                        <select required name="id_attribute_color[]" class="form-select mb-3 variant-select color-select " id="color-${variantCounter}" aria-label="Default select example">
                            <option value="">Chọn màu sắc</option>
                            @foreach ($colors as $color)
                                <option value="{{ $color->id }}">{{ $color->name }} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group me-1">
                        <label for="size-${variantCounter}" class="form-label">Kích thước</label>
                        <select name="id_attribute_size[]" class="form-select mb-3 variant-select size-select " id="size-${variantCounter}" aria-label="Default select example">
                            <option value="" >Chọn kích thước</option>
                           @foreach ($sizes as $size)
                                <option value="{{ $size->id }}">{{ $size->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="me-1">
                        <label for="price_in-${variantCounter}" class="form-label">Giá nhập</label>
                        <input name="import_price[]" type="number" required min=0 class="form-control price-validate price_in" id="price_in-${variantCounter}" placeholder="Nhập giá nhập">
                    </div>
                    <div class="me-1">
                        <label for="price_out-${variantCounter}" class="form-label">Giá niêm yết</label>
                        <input name="list_price[]" type="number" required min=0 class="form-control price-validate price_out" id="price_out-${variantCounter}" placeholder="Nhập giá niêm yết">
                    </div>
                    <div class="me-1">
                        <label for="sale_price-${variantCounter}" class="form-label">Giá bán</label>
                        <input name="selling_price[]" type="number" required min=0  class="form-control price-validate sale_price" id="sale_price-${variantCounter}" placeholder="Nhập giá bán">
                    </div>
                    <div class="me-1">
                        <label for="quantity-${variantCounter}" class="form-label">Số lượng</label>
                        <input name="quantity[]" type="number" required min=0 class="form-control" id="quantity-${variantCounter}" placeholder="Nhập số lượng">
                    </div>
                    <div class="me-1">
                        <label for="image_color-${variantCounter}" class="form-label">Ảnh</label>
                        <input name="image_color[]" type="file" min=0 class="form-control" id="image_color-${variantCounter}" placeholder="Nhập ảnh">
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

        if (totalVariants >= 1) {
            let variantId = $(this).data('variant-id');
            $('#' + variantId).remove();
        }

    });


    $(document).on('input', '.price-validate', function() {
        let variantId = $(this).closest('.variant-row').attr('id');

        let import_price = parseFloat($('#' + variantId + ' .price_in').val());
        let list_price = parseFloat($('#' + variantId + ' .price_out').val());
        let selling_price = parseFloat($('#' + variantId + ' .sale_price').val());

        let price = parseFloat($(this).val());

        if (price < 0) {
            $(this).addClass('is-invalid');
            $(this).after('<div class="invalid-feedback">Giá phải lớn hơn hoặc bằng 0.</div>');
        } else {
            $(this).removeClass('is-invalid');
            $(this).next('.invalid-feedback').remove();
        }

        if (list_price <= import_price) {
            $('#' + variantId + ' .price_out').addClass('is-invalid');
            $('#' + variantId + ' .price_out').next('.invalid-feedback').remove();
            $('#' + variantId + ' .price_out').after(
                '<div class="invalid-feedback">Giá niêm yết phải lớn hơn giá nhập.</div>');
        } else {
            $('#' + variantId + ' .price_out').removeClass('is-invalid');
            $('#' + variantId + ' .price_out').next('.invalid-feedback').remove();
        }

        if (selling_price <= import_price) {
            $('#' + variantId + ' .sale_price').addClass('is-invalid');
            $('#' + variantId + ' .sale_price').next('.invalid-feedback').remove();
            $('#' + variantId + ' .sale_price').after(
                '<div class="invalid-feedback">Giá bán phải lớn hơn giá nhập.</div>');
        } else if (selling_price > list_price) {
            $('#' + variantId + ' .sale_price').addClass('is-invalid');
            $('#' + variantId + ' .sale_price').next('.invalid-feedback').remove();
            $('#' + variantId + ' .sale_price').after(
                '<div class="invalid-feedback">Giá bán phải nhỏ hơn hoặc bằng giá niêm yết.</div>');
        } else {
            $('#' + variantId + ' .sale_price').removeClass('is-invalid');
            $('#' + variantId + ' .sale_price').next('.invalid-feedback').remove();
        }
    });

    $(document).on('change', '.variant-select', function() {
        let selectedVariants = [];
        $('.variant-row').each(function() {
            let color = $(this).find('.color-select').val();
            let size = $(this).find('.size-select').val();
            let variant = color + '-' + size;
            if (!size) {
                if (selectedVariants.includes(color) && color) {
                    alert(
                        'Màu này đã được chọn . Vui lòng chọn màu khác.'
                    );
                    $(this).find('.color-select').val('');
                } else {
                    selectedVariants.push(color);
                }
            } else {
                if (selectedVariants.includes(variant) && color && size) {
                    alert('Màu và kích thước này đã tồn tại. Vui lòng chọn màu hoặc kích thước khác.');
                    $(this).find('.color-select').val('');
                    $(this).find('.size-select').val('');
                } else {
                    selectedVariants.push(variant);
                }
            }
        });
    });
</script>
@endsection