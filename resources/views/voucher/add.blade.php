@extends('layouts.app-theme')


@push('scripts')
@endpush

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
                        {{-- <div>
                            <label for="basiInput" class="form-label">Sản phẩm</label>
                            <input type="text" class="form-control @error('id_product') is-invalid @enderror" id="basiInput"
                                name="id_product" value="{{ old('product->name') }}">
                        </div> --}}
                        <div class="">
                            <label for="basiInput" class="form-label">Mã code</label>
                            <input required type="text" class="form-control mb-3 @error('code') is-invalid @enderror" id="basiInput"
                                name="code" value="{{ old('code') }}">
                        </div>
                        <div class="">
                            <label for="basiInput" class="form-label">Loại giảm giá</label>
                            <select required name="discount_type" class="form-select mb-3" id=" "
                                aria-label="Default select example">
                                <option value="">Chọn</option>
                                <option value="1" {{ old('discount_type') == 1 ? 'selected' : ''}} >Giảm giá theo phần trăm</option>
                                <option value="2" {{ old('discount_type') == 2 ? 'selected' : ''}}>Giảm giá giá trị cố định</option>


                            </select>
                        </div>
                        <div class="">
                            <label for="basiInput" class="form-label">Mức ưu đãi</label>
                            <input required type="number" class="form-control mb-3 @error('discount_value') is-invalid @enderror"
                                id="basiInput" name="discount_value" value="{{ old('discount_value') }}">
                        </div>
                        <div class="d-flex gap-3 mb-3">
                            <div class="">
                                <label for="basiInput" class="form-label">Ngày bắt đầu</label>
                                <input required type="date" class="form-control @error('start_date') is-invalid @enderror"
                                    id="basiInput" name="start_date" value="{{ old('start_date') }}">
                            </div>
                            <div class="">
                                <label for="basiInput" class="form-label">Ngày kết thúc</label>
                                <input required type="date" class="form-control @error('end_date') is-invalid @enderror"
                                    id="basiInput" name="end_date" value="{{ old('end_date') }}">
                            </div>
                        </div>
                        <div class="">
                            <label for="basiInput" class="form-label">Giới hạn sử dụng cho mỗi mã giảm giá</label>
                            <input required type="number" class="form-control mb-3 @error('usage_limit') is-invalid @enderror"
                                id="basiInput" name="usage_limit" value="{{ old('usage_limit') }}">
                        </div>
                        <div class="">
                            <label for="basiInput" class="form-label">Giới hạn sử dụng trên mỗi người dùng</label>
                            <input required type="number" class="form-control @error('usage_per_user') is-invalid @enderror"
                                id="basiInput" name="usage_per_user" value="{{ old('usage_per_user') }}">
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
