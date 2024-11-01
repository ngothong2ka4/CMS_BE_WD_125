@extends('layouts.app-theme')


@push('scripts')
@endpush

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Chi tiết mã giảm giá</h5>
                </div>
                <div class="card-body">
                    <form>
                        <div class="">
                            <label for="basiInput" class="form-label">Mã code</label>
                            <input type="text" class="form-control mb-3 @error('code') is-invalid @enderror" id="basiInput"
                                name="code" value="{{ $voucher->code }}" disabled>
                        </div>
                        <div>
                            <label for="basiInput" class="form-label">Mô tả</label>
                            <textarea disabled class="form-control mb-3" name="description" id="meassageInput" rows="3">{{ $voucher->description }}</textarea>
                        </div>
                        <div class="">
                            <label for="basiInput" class="form-label">Loại giảm giá</label>
                            <select required name="discount_type" class="form-select mb-3" id="discount_type" onchange="toggleDiscountFields()"
                                aria-label="Default select example" disabled>
                                <option value="">Chọn</option>
                                <option value="1" {{ $voucher->discount_type == 1 ? 'selected' : ''}} >Giảm giá theo phần trăm</option>
                                <option value="2" {{ $voucher->discount_type == 2 ? 'selected' : ''}}>Giảm giá giá trị cố định</option>

                            </select>
                        </div>
                        <div class="">
                            <label for="basiInput" class="form-label">Mức ưu đãi</label>
                            <input type="number" class="form-control mb-3 @error('discount_value') is-invalid @enderror"
                                id="basiInput" name="discount_value" value="{{ $voucher->discount_value }}" disabled>
                        </div>
                        <div id="percentageDiscount" style="display: {{ old('discount_type') == 1 ? 'block' : 'none' }};">

                            <div class="">
                                <label for="basiInput" class="form-label">Số tiền giảm tối đa</label>
                                <input type="number"
                                    class="form-control mb-3 @error('max_discount_amount') is-invalid @enderror"
                                    id="basiInput" name="max_discount_amount" 
                                    placeholder="Nhập tiền giảm tối đa (VD: 1000 = 1000đ)"
                                    value="{{ $voucher->max_discount_amount }}" disabled>
                            </div>
                        </div>
                        <div class="">
                            <label for="basiInput" class="form-label">Người có thể sử dụng ưu đãi</label>
                            <select required name="user_voucher_limit" class="form-select mb-3" id="user_voucher_limit"
                                aria-label="Default select example" onchange="toggleFields()" disabled>
                                <option value="">Chọn</option>
                                <option value="1" {{ $voucher->user_voucher_limit == 1 ? 'selected' : '' }}>Tất cả mọi
                                    người</option>
                                <option value="2" {{ $voucher->user_voucher_limit == 2 ? 'selected' : '' }}>Người có
                                    điểm
                                    tích lũy trong khoảng</option>
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
                                        value="{{ $voucher->min_accumulated_points }}" placeholder="Nhập điểm tích lũy nhỏ" disabled>
                                </div>
                                <div class="col-6">
                                    <label for="basiInput" class="form-label">Đến</label>
                                    <input type="number"
                                        class="form-control mb-3 @error('max_accumulated_points') is-invalid @enderror"
                                        id="basiInput" name="max_accumulated_points"
                                        value="{{ $voucher->max_accumulated_points }}" placeholder="Nhập điểm tích lũy lớn" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex gap-3 mb-3">
                            <div class="">
                                <label for="basiInput" class="form-label">Ngày bắt đầu</label>
                                <input type="date" class="form-control @error('start_date') is-invalid @enderror"
                                    id="basiInput" name="start_date" value="{{ $voucher->start_date }}" disabled>
                            </div>
                            <div class="">
                                <label for="basiInput" class="form-label">Ngày kết thúc</label>
                                <input type="date" class="form-control @error('end_date') is-invalid @enderror"
                                    id="basiInput" name="end_date" value="{{ $voucher->end_date }}" disabled>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="basiInput" class="form-label">Giới hạn sử dụng cho mỗi mã giảm giá</label>
                            <input type="number" class="form-control @error('usage_limit') is-invalid @enderror"
                                id="basiInput" name="usage_limit" value="{{ $voucher->usage_limit }}" disabled>
                        </div>
                        <div class="">
                            <label for="basiInput" class="form-label">Giới hạn sử dụng trên mỗi người dùng</label>
                            <input type="number" class="form-control @error('usage_per_user') is-invalid @enderror"
                                id="basiInput" name="usage_per_user" value="{{ $voucher->usage_per_user }}" disabled>
                        </div>
                        <div class="mt-3">
                        <a href="{{ route('voucher.index') }}" class="btn btn-success">Quay lại</a>
                        </div>
                    </form>
                </div>
            </div>
        </div><!--end col-->
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        toggleDiscountFields();
        toggleFields();
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
        if (userVoucherLimit == 2) {
            conditionalFields.style.display = 'block';
        } else {
            conditionalFields.style.display = 'none';
        }
    }
</script>
@endpush
