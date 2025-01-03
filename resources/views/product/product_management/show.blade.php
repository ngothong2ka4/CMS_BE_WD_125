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
                    <h2 class="mb-0">Chi tiết sản phẩm</h2>
                </div>
            </div>

            <form action="{{ route('product_management.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card mb-2">
                    <div class="card-header">
                        <h4 class="mb-0">Thông tin chung</h4>
                    </div>
                    <div class="card-body">
                        <div>
                            <label for="basiInput" class="form-label">Tên sản phẩm</label>
                            <input type="text" class="form-control mb-3" id="basiInput" name="name"
                                value="{{ $product->name }}" disabled>

                        </div>
                        <div>
                            <label for="basiInput" class="form-label">Danh mục sản phẩm</label>
                            <select name="id_category" class="form-select mb-3" aria-label="Default select example"
                                disabled>
                                <option value="">Chọn danh mục</option>
                                @foreach ($categories as $category)
                                    <option {{ $category->id === $product->id_category ? 'selected' : '' }}
                                        value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>

                        </div>
                        <div>
                            <label for="basiInput" class="form-label">Chất liệu sản phẩm</label>
                            <select name="id_materials" class="form-select mb-3" aria-label="Default select example"
                                disabled>
                                <option value="">Chọn chất liệu</option>
                                @foreach ($materials as $material)
                                    <option {{ $material->id === $product->id_materials ? 'selected' : '' }}
                                        value="{{ $material->id }}">{{ $material->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="basiInput" class="form-label">Đá</label>
                            <select name="id_stones" class="form-select mb-3" aria-label="Default select example" disabled>
                                <option value="">Chọn đá</option>
                                @foreach ($stones as $stone)
                                    <option {{ $stone->id === $product->id_stones ? 'selected' : '' }}
                                        value="{{ $stone->id }}">{{ $stone->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="basiInput" class="form-label">Hình ảnh</label>
                            <img class="mb-3 pl-5" src="{{ $product->thumbnail }}" width=80 alt="">
                            @error('thumbnail')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div>
                            <label for="basiInput" class="form-label">Mô tả</label>
                            <textarea class="form-control mb-3" name="description" id="meassageInput" rows="3" placeholder="Nhập mô tả" disabled>{{ $product->description }}</textarea>
                        </div>
                        <div class="text-break">

                            <label for="basiInput" class="form-label">Hình ảnh cho slide:</label>
                        <br>
                            @foreach($images as $image)
                            <div class=" d-inline-block mr-2 mb-2" style=" width: 8%;">
    
                                <a href="{{route('delImage',$image->id)}}"> <button type="button"
                                        onclick="return confirm('Bạn có muốn xóa không?')"
                                        class="btn btn-sm btn-outline-danger border-0 position-absolute">
                                        X
    
                                    </button></a>
    
                                <div style="width: 80px; height: 80px; overflow: hidden;">
                                    <img width="100%" src="{{$image->link_image}}"
                                        alt="Image">
                                </div>
                        </div>
                            @endforeach
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
                            @foreach ($variants as $var)
                                <input type="hidden" name="id_var[]" value="{{ $var->id }}">
                                <div class="form-group d-flex" id="">
                                    <div class="form-group me-1">
                                        <label for="color-${variantCounter}" class="form-label">Màu sắc</label>
                                        <select required name="id_attribute_color[]" class="form-select mb-3"
                                            id="color-${variantCounter}" aria-label="Default select example" disabled>
                                            <option value="">Chọn màu sắc</option>
                                            @foreach ($colors as $color)
                                                <option {{ $color->id == $var->id_attribute_color ? 'selected' : '' }}
                                                    value="{{ $color->id }}">
                                                    {{ $color->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group me-1">
                                        <label for="size-${variantCounter}" class="form-label">Kích thước</label>
                                        <select required name="id_attribute_size[]" class="form-select mb-3"
                                            id="size-${variantCounter}" aria-label="Default select example" disabled>
                                            <option value="">Chọn kích thước</option>
                                            @foreach ($sizes as $size)
                                                <option {{ $size->id === $var->id_attribute_size ? 'selected' : '' }}
                                                    value="{{ $size->id }}">{{ $size->name }}</option>
                                            @endforeach



                                        </select>
                                    </div>
                                    <div class="me-1">
                                        <label for="price_in-${variantCounter}" class="form-label">Giá nhập</label>
                                        <input value="{{ number_format($var->import_price, 0, '.', '') }}"
                                            name="import_price[]" type="text" required min=0 class="form-control"
                                            id="price_in-${variantCounter}" placeholder="Nhập giá nhập" disabled>
                                    </div>
                                    <div class="me-1">
                                        <label for="price_out-${variantCounter}" class="form-label">Giá niêm yết</label>
                                        <input value="{{ number_format($var->list_price, 0, '.', '') }}"
                                            name="list_price[]" type="text" required min=0 class="form-control"
                                            id="price_out-${variantCounter}" placeholder="Nhập giá niêm yết" disabled>
                                    </div>
                                    <div class="me-1">
                                        <label for="sale_price-${variantCounter}" class="form-label">Giá bán</label>
                                        <input value="{{ number_format($var->selling_price, 0, '.', '') }}"
                                            name="selling_price[]" type="text" required min=0 class="form-control"
                                            id="sale_price-${variantCounter}" placeholder="Nhập giá bán" disabled>
                                    </div>
                                    <div class="me-1">
                                        <label for="quantity-${variantCounter}" class="form-label">Số lượng</label>
                                        <input value="{{ $var->quantity }}" name="quantity[]" type="number" required
                                            min=0 class="form-control" id="quantity-${variantCounter}"
                                            placeholder="Nhập số lượng" disabled>
                                    </div>
                                    <div class="me-1">
                                        <label for="image-${variantCounter}" class="form-label">Ảnh</label>
                                        <img class="mb-3 pl-5" src="{{ $var->image_color }}" width=100 height=100
                                            alt="">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="mt-3 ms-auto me-auto mb-2">
                        <a href="{{ route('product_management.index') }}" class="btn btn-success">Quay lại</a>
                    </div>
                </div>

            </form>
        </div><!--end col-->
    </div>
@endsection

{{-- @push('scripts')
    <script>
        let variantCounter = 1;

        $('#add-variant-btn').click(function() {
            variantCounter++;

            let newVariant = `
                <div class="form-group d-flex" id="variant-${variantCounter}">
                    <div class="form-group me-1">
                        <label for="color-${variantCounter}" class="form-label">Màu sắc</label>
                        <select required name="new_id_attribute_color[]" class="form-select mb-3" id="color-${variantCounter}" aria-label="Default select example">
                            <option value="">Chọn màu sắc</option>
                            @foreach ($colors as $color)
                                <option value="{{ $color->id }}">{{ $color->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group me-1">
                        <label for="size-${variantCounter}" class="form-label">Kích thước</label>
                        <select required name="new_id_attribute_size[]" class="form-select mb-3" id="size-${variantCounter}" aria-label="Default select example">
                            <option value="" >Chọn kích thước</option>
                           @foreach ($sizes as $size)
                                <option value="{{ $size->id }}">{{ $size->name }}</option>
                            @endforeach
                           
                        
                               
                        </select>
                    </div>
                    <div class="me-1">
                        <label for="price_in-${variantCounter}" class="form-label">Giá nhập</label>
                        <input name="new_import_price[]" type="number" required min=0 class="form-control" id="price_in-${variantCounter}" placeholder="Nhập giá nhập">
                    </div>
                    <div class="me-1">
                        <label for="price_out-${variantCounter}" class="form-label">Giá niêm yết</label>
                        <input name="new_list_price[]" type="number" required min=0 class="form-control" id="price_out-${variantCounter}" placeholder="Nhập giá niêm yết">
                    </div>
                    <div class="me-1">
                        <label for="sale_price-${variantCounter}" class="form-label">Giá bán</label>
                        <input name="new_selling_price[]" type="number" required min=0 type="text" class="form-control" id="sale_price-${variantCounter}" placeholder="Nhập giá bán">
                    </div>
                    <div class="me-1">
                        <label for="quantity-${variantCounter}" class="form-label">Số lượng</label>
                        <input name="new_quantity[]" type="number" required min=0 class="form-control" id="quantity-${variantCounter}" placeholder="Nhập số lượng">
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
    </script>
@endpush --}}
