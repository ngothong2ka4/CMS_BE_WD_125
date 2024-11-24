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
                <h2 class="mb-0">Sửa dịch vụ</h2>
            </div>
        </div>

        <form action="{{ route('ads_service.update',$ads->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card mb-2">
               
                <div class="card-body">
                    <div>
                        <label for="basiInput" class="form-label">Tên khách hàng</label>
                        <input type="text" class="form-control mb-3" id="basiInput" name="name"
                            value="{{ $ads->name }}">
                    </div>
                    <div>
                        <label for="basiInput" class="form-label">Số điện thoại</label>
                        <input type="text" class="form-control mb-3" id="basiInput" name="phone"
                            value="{{ $ads->phone }}">
                    </div>
                    <div>
                        <label for="basiInput" class="form-label">Email</label>
                        <input type="email" class="form-control mb-3" id="basiInput" name="email"
                            value="{{ $ads->email }}">
                    </div>
                    <div>
                        <label for="basiInput" class="form-label">Thời hạn</label>
                        <select name="duration" class="form-select mb-3" aria-label="Default select example">
                            <option value="none">Vô thời hạn</option>
                            <option value="1h"  {{ $ads->duration == '1h' ? 'selected' : '' }}>1 giờ</option>
                            <option value="12h" {{ $ads->duration == '12h' ? 'selected' : '' }}>12 giờ</option>
                            <option value="1d" {{ $ads->duration == '1d' ? 'selected' : '' }}>1 ngày</option>
                            <option value="1w" {{ $ads->duration == '1w' ? 'selected' : '' }}>1 tuần</option>
                            <option value="1m" {{ $ads->duration == '1m' ? 'selected' : '' }}>1 tháng</option>
                            <option value="6m" {{ $ads->duration == '6m' ? 'selected' : '' }}>6 tháng</option>
                        </select>
                    
                    </div>
                    <div>
                        <label for="basiInput" class="form-label">Đơn giá</label>
                        <input type="number" class="form-control mb-3" id="basiInput" name="price"
                            value="{{ number_format($ads->price, 0, '.', '') }}">
                    </div>
                    <div>
                        <label for="basiInput" class="form-label">Tiêu đề</label>
                        <input type="text" class="form-control mb-3" id="basiInput" name="title"
                            value="{{ $config->title }}">
                    </div>
                    <div>
                        <label for="basiInput" class="form-label">Đường dẫn</label>
                        <input type="text" class="form-control mb-3" id="basiInput" name="url"
                            value="{{ $config->url }}">
                    </div>
                    <div>
                        <label for="basiInput" class="form-label">Hình ảnh</label>
                        <div class="mb-3 pl-5" style="width: 80px; height: 80px; overflow: hidden;">
                        <img class="mb-3 pl-5" src="{{ $config->image }}" width=80 alt="">
                        </div>
                        <input type="file" name="image" id="" class="form-control mb-3">
                       
                    </div>
                    <div>
                        <label for="basiInput" class="form-label">Điểm nổi bật</label>
                        <textarea class="form-control mb-3" name="highlight" id="meassageInput" rows="3" >{{ $config->highlight }}</textarea>
                    </div>
                </div>
                <div class="mt-3 ms-auto me-auto mb-2">
                    <button class="btn btn-success" type="submit">Lưu</button>
                </div>
            </div>
            </form>
    </div><!--end col-->
</div>
@endsection