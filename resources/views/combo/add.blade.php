@extends('layouts.app-theme')


@push('scripts')
@endpush

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Thêm mới bộ trang sức</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('combo.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div>
                            <label class="form-label">Tên bộ trang sức</label>
                            <input type="text" class="form-control mb-3 @error('name') is-invalid @enderror" name="name"
                                value="{{ old('name') }}">
                        </div>
                        <div>
                            <label class="form-label">Ảnh bộ trang sức</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" name="image">
                        </div>
                        <div class="d-flex bd-highlight my-3">
                            <label for="" class="form-label">Chọn sản phẩm </label>
                            <div class="w-50 mx-3">
                                <select id="id_product" name="id_product[]" class="form-control" multiple="multiple"
                                    style="width: 100%;">
                                    @foreach ($productsWithMinValues as $product)
                                        <option value="{{ $product['id'] }}" data-min-price="{{ $product['min_price'] }}"
                                            data-min-quantity="{{ $product['min_quantity'] }}"
                                            {{ in_array($product['id'], old('id_product', [])) ? 'selected' : '' }}>
                                            {{ $product['name'] }} (Giá: {{ number_format($product['min_price']) }}
                                            - SL: {{ $product['min_quantity'] }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="d-flex w-50">
                                <div class="d-flex mx-3">
                                    <label for="" class="form-label">Tổng giá sản phẩm</label>
                                    <input type="number" class="form-control mb-3" id="total_price" name="total_price"
                                        value="{{ old('total_price') }}" readonly>
                                </div>
                                <div class="d-flex mx-3">
                                    <label for="" class="form-label">Số lượng sản phẩm</label>
                                    <input type="number" class="form-control mb-3" id="minQuantity" name="minQuantity"
                                        value="{{ old('minQuantity') }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-6">
                                <label class="form-label">Giá bộ trang sức</label>
                                <input type="number" class="form-control @error('price') is-invalid @enderror"
                                    name="price" value="{{ old('price') }}">
                            </div>
                            <div class="col-6">
                                <label class="form-label">Số lượng bộ trang sức</label>
                                <input type="number" class="form-control @error('quantity') is-invalid @enderror"
                                    name="quantity" value="{{ old('quantity') }}">
                            </div>
                        </div>
                        <div>
                            <label class="form-label">Mô tả</label>
                            <textarea name="description" id="" class="form-control" cols="30" rows="2">{{ old('description') }}</textarea>
                        </div>

                        <div class="mt-3">
                            <button type="submit" class="btn btn-success">Thêm mới</button>
                        </div>
                    </form>
                </div>
            </div>
        </div><!--end col-->
    </div>
@endsection

@push('scripts')
@endpush
