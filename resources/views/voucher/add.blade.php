@extends('layouts.app-theme')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Thêm mới mã giảm giá</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('voucher.store') }}" method="POST">
                        @csrf
                        {{-- <div class="d-flex">
                            <label for="basiInput" class="form-label">Chọn sản phẩm sử dụng voucher</label>
                            <div class="mx-3">
                                <select id="id_product" name="id_product[]" value="{{ old('id_product') }}" class="form-control" multiple="multiple" style="width: 100%;">
                                    @foreach ($products as $product)
                                    <option value="{{ $product->id }}" 
                                        {{ in_array($product->id, old('id_product', [])) ? 'selected' : '' }}>
                                        {{ $product->name }}
                                    </option>
                                @endforeach
                                </select>
                            </div>
                        </div> --}}
                        <div class="d-flex">
                            <div class="w-50">
                                <label for="basiInput" class="form-label">Mã code<span class="text-danger">*</span></label>
                                <input type="text" class="form-control w-50 mb-3 @error('code') is-invalid @enderror"
                                    id="basiInput" name="code" value="{{ old('code') }}">
                            </div>
                            <div class="w-50">
                                <label for="basiInput" class="form-label">Tên <span class="text-danger">*</span></label>
                                <input type="text" class="form-control w-50 mb-3 @error('title') is-invalid @enderror"
                                    id="basiInput" name="title" value="{{ old('title') }}">
                            </div>
                        </div>
                        <div>
                            <label for="basiInput" class="form-label">Mô tả</label>
                            <textarea class="form-control mb-3" name="description" id="meassageInput" rows="3" placeholder="Nhập mô tả">{{ old('description') }}</textarea>
                        </div>
                        <div class="">
                            <label for="basiInput" class="form-label">Loại giảm giá <span
                                    class="text-danger">*</span></label>
                            <select name="discount_type" class="form-select mb-3 w-25" id="discount_type"
                                aria-label="Default select example" onchange="toggleDiscountFields()">
                                {{-- <option value="">Chọn</option> --}}
                                <option value="2" {{ old('discount_type') == 2 ? 'selected' : '' }}>Giảm giá giá trị cố
                                    định</option>
                                <option value="1" {{ old('discount_type') == 1 ? 'selected' : '' }}>Giảm giá theo phần
                                    trăm</option>


                            </select>
                        </div>
                        <div class="d-flex">
                            <div class="w-50">
                                <label for="basiInput" class="form-label">Mức ưu đãi <span
                                        class="text-danger">*</span></label>
                                <input type="number"
                                    class="form-control mb-3 @error('discount_value') is-invalid @enderror"
                                    id="discount_value" name="discount_value" value="{{ old('discount_value') }}"
                                    placeholder="Nhập mức ưu đãi (VD: 10 = 10%; 1000 = 1000đ)">
                            </div>
                            <div class="w-50 mx-3" id="percentageDiscount"
                                style="display: {{ old('discount_type') == 1 ? 'block' : 'none' }};">

                                <div class="">
                                    <label for="basiInput" class="form-label">Số tiền giảm tối đa<span
                                            class="text-danger">*</span></label>
                                    <input type="number"
                                        class="form-control mb-3 @error('max_discount_amount') is-invalid @enderror"
                                        id="basiInput" name="max_discount_amount"
                                        placeholder="Nhập tiền giảm tối đa (VD: 1000 = 1000đ)"
                                        value="{{ old('max_discount_amount') }}">
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <label for="basiInput" class="form-label">Người có thể sử dụng ưu đãi<span
                                    class="text-danger">*</span></label>
                            <select name="user_voucher_limit" class="form-select mb-3 w-25" id="user_voucher_limit"
                                aria-label="Default select example" onchange="toggleFields()">
                                {{-- <option value="">Chọn</option> --}}
                                <option value="1" {{ old('user_voucher_limit') == 1 ? 'selected' : '' }}>Tất cả mọi
                                    người</option>
                                <option value="2" {{ old('user_voucher_limit') == 2 ? 'selected' : '' }}>Người có điểm
                                    tích lũy trong khoảng</option>
                                <option value="3" {{ old('user_voucher_limit') == 3 ? 'selected' : '' }}>Người dùng mã
                                    ưu đãi cụ thể</option>
                            </select>
                        </div>
                        <div id="conditionalFields"
                            style="display: {{ old('user_voucher_limit') == 2 ? 'block' : 'none' }};">
                            <div class="d-flex gap-3">
                                <div class="col-6">
                                    <label for="basiInput" class="form-label">Từ</label>
                                    <input type="number"
                                        class="form-control mb-3 @error('min_accumulated_points') is-invalid @enderror"
                                        id="basiInput" name="min_accumulated_points"
                                        value="{{ old('min_accumulated_points') }}" placeholder="Nhập điểm tích lũy nhỏ">
                                </div>
                                <div class="col-6">
                                    <label for="basiInput" class="form-label">Đến</label>
                                    <input type="number"
                                        class="form-control mb-3 @error('max_accumulated_points') is-invalid @enderror"
                                        id="basiInput" name="max_accumulated_points"
                                        value="{{ old('max_accumulated_points') }}" placeholder="Nhập điểm tích lũy lớn">
                                </div>
                            </div>
                        </div>
                        <div id="conditionalUserField"
                            style="display: {{ old('user_voucher_limit') == 3 ? 'block' : 'none' }};">
                            <div class="d-flex gap-3">
                                <div class="m-3">
                                    <label for="id_user" class="form-label">Chọn người dùng<span
                                            class="text-danger">*</span></label>
                                    <select id="id_user" name="id_user[]" class="form-control" multiple="multiple"
                                        style="width: 100%;">
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}"
                                                {{ in_array($user->id, old('id_user', [])) ? 'selected' : '' }}>
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex gap-3 mb-3">
                            <div class="">
                                <label for="basiInput" class="form-label">Ngày bắt đầu<span
                                        class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('start_date') is-invalid @enderror"
                                    id="basiInput" name="start_date" value="{{ old('start_date') }}">
                            </div>
                            <div class="">
                                <label for="basiInput" class="form-label">Ngày kết thúc<span
                                        class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('end_date') is-invalid @enderror"
                                    id="basiInput" name="end_date" value="{{ old('end_date') }}">
                            </div>
                        </div>
                        <div class="d-flex">
                            <div class="m-3">
                                <label for="basiInput" class="form-label">Giới hạn sử dụng cho mỗi mã giảm giá</label>
                                <input type="number" class="form-control mb-3 @error('usage_limit') is-invalid @enderror"
                                    id="basiInput" name="usage_limit" value="{{ old('usage_limit') }}">
                            </div>
                            <div class="m-3">
                                <label for="basiInput" class="form-label">Giới hạn sử dụng trên mỗi người dùng</label>
                                <input type="number" class="form-control @error('usage_per_user') is-invalid @enderror"
                                    id="basiInput" name="usage_per_user" value="{{ old('usage_per_user') }}">
                            </div>
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
