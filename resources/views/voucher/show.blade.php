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
                            <select required name="discount_type" class="form-select mb-3" id=" "
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
@endpush
