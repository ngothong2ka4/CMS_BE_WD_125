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
                        <div class="form-group d-flex">
                            <div class="form-group me-1">
                                <label for="basiInput" class="form-label">Màu sắc</label>
                                <select class="form-select mb-3" aria-label="Default select example">
                                    <option selected>Open this select menu</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </div>
                            <div class="form-group me-1">
                                <label for="basiInput" class="form-label">Kích thước</label>
                                <select class="form-select mb-3" aria-label="Default select example">
                                    <option selected>Open this select menu</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </div>
                            <div class="me-1">
                                <label for="basiInput" class="form-label">Giá nhập</label>
                                <input type="text" class="form-control" id="basiInput" name="name">
                            </div>
                            <div class="me-1">
                                <label for="basiInput" class="form-label">Giá niêm yết</label>
                                <input type="text" class="form-control" id="basiInput" name="name">
                            </div>
                            <div class="me-1">
                                <label for="basiInput" class="form-label">Giá bán</label>
                                <input type="text" class="form-control" id="basiInput" name="name">
                            </div>
                            <div class="me-1">
                                <label for="basiInput" class="form-label">Số lượng</label>
                                <input type="number" class="form-control" id="basiInput" name="name">
                            </div>
                            <div style="margin-top: 27px">
                                <button class="btn btn-danger" type="submit">Xoá</button>
                            </div>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-outline-info">Thêm biến thể</button>
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
    
@endpush
