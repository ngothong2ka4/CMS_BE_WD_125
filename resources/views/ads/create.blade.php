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
                <h2 class="mb-0">Thêm mới dịch vụ</h2>
            </div>
        </div>

        <form action="{{ route('ads_service.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card mb-2">
               
                <div class="card-body">
                    <div>
                        <label for="basiInput" class="form-label">Tên khách hàng</label>
                        <input type="text" class="form-control mb-3" id="basiInput" name="name"
                            value="{{ old('name') }}">
                    </div>
                    <div>
                        <label for="basiInput" class="form-label">Số điện thoại</label>
                        <input type="text" class="form-control mb-3" id="basiInput" name="phone"
                            value="{{ old('phone') }}">
                    </div>
                    <div>
                        <label for="basiInput" class="form-label">Email</label>
                        <input type="email" class="form-control mb-3" id="basiInput" name="email"
                            value="{{ old('email') }}">
                    </div>
                    <div>
                        <label for="basiInput" class="form-label">Thời hạn</label>
                        <select name="duration" class="form-select mb-3" aria-label="Default select example">
                            <option value="none">Vô thời hạn</option>
                            <option value="1h"  {{ old('duration') == '1h' ? 'selected' : '' }}>>1 giờ</option>
                            <option value="12h" {{ old('duration') == '12h' ? 'selected' : '' }}>12 giờ</option>
                            <option value="1d" {{ old('duration') == '1d' ? 'selected' : '' }}>1 ngày</option>
                            <option value="1w" {{ old('duration') == '1w' ? 'selected' : '' }}>1 tuần</option>
                            <option value="1m" {{ old('duration') == '1m' ? 'selected' : '' }}>1 tháng</option>
                            <option value="6m" {{ old('duration') == '6m' ? 'selected' : '' }}>6 tháng</option>
                        </select>
                    
                    </div>
                    <div>
                        <label for="basiInput" class="form-label">Đơn giá</label>
                        <input type="number" class="form-control mb-3" id="basiInput" name="price"
                            value="{{ old('price') }}">
                    </div>
                    <div>
                        <label for="basiInput" class="form-label">Tiêu đề</label>
                        <input type="text" class="form-control mb-3" id="basiInput" name="title"
                            value="{{ old('title') }}">
                    </div>
                    <div>
                        <label for="basiInput" class="form-label">Đường dẫn</label>
                        <input type="text" class="form-control mb-3" id="basiInput" name="url"
                            value="{{ old('url') }}">
                    </div>
                    <div>
                        <label for="basiInput" class="form-label">Hình ảnh</label>
                        <input type="file" name="image" id="" class="form-control mb-3">
                       
                    </div>
                    <div>
                        <label for="basiInput" class="form-label">Điểm nổi bật</label>
                        <textarea class="form-control mb-3" name="highlight" id="meassageInput" rows="3" >{{ old('highlight') }}</textarea>
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