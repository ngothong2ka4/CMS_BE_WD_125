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
                    <h2 class="mb-0">Thông tin chi tiết tài khoản</h2>
                </div>
            </div>

            <div class="p-2 mt-4">


                <form action="{{ route('admin.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card mb-2">
                        {{-- <div class="card-header">
                        <h4 class="mb-0">Thông tin tài khoản</h4>
                    </div> --}}

                        <div class="card-body">
                            <div>
                                <label for="basiInput" class="form-label">Tên người dùng</label>
                                <input type="text" class="form-control" id="basiInput" name="name"
                                    value="{{ old('name') }}">

                            </div>
                            <div>
                                <label for="basiInput" class="form-label">Ảnh Avatar</label>
                                <input type="file" name="image" class="form-control">
                            </div>
                            <div>
                                <label for="basiInput" class="form-label">Số điện thoại</label>
                                <input type="phone" class="form-control" id="basiInput" name="phone_number" value="{{old('phone_number')}}">

                            </div>
                            <div>
                                <label for="basiInput" class="form-label">Email</label>
                                <input type="email" class="form-control" id="basiInput" name="email"
                                    value="{{ old('email') }}">

                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="password">Mật khẩu</label>
                                <div class="position-relative auth-pass-inputgroup">
                                    <input type="password" class="form-control pe-5 password-input" name="password"
                                        id="password" aria-describedby="passwordInput" value="{{ old('password') }}">
                                    <button
                                        class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon"
                                        type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>

                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="password">Nhập lại mật khẩu</label>
                                <div class="position-relative auth-pass-inputgroup">
                                    <input type="password" class="form-control pe-5 password-input"
                                        name="password_confirmation" id="password_confirmation"
                                        aria-describedby="passwordInput" value="{{ old('password_confirmation') }}">
                                    <button
                                        class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon"
                                        type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>

                                </div>
                            </div>
                            <div>
                                <label for="basiInput" class="form-label">Địa chỉ</label>
                                <input type="text" class="form-control" id="basiInput" name="address"
                                    value="{{ old('address') }}">

                            </div>
                            {{-- <div class="d-flex gap-2">
                                <div>
                                    <label for="basiInput" class="form-label">Quyền</label>
                                    <input type="text" class="form-control" id="basiInput" name="role"
                                    value="2">
    
    
                                </div>
                                <div>
                                    <label for="basiInput" class="form-label">Trang thái</label>
                                    <input type="text" class="form-control" id="basiInput" name="status"
                                        value="{{ $user->status ? 'Kích hoạt' : 'Dừng kích hoạt' }}" >
                                        <select class="form-select mb-3" name="status" >
                                            <option value="1">Hoạt động</option>
                                            <option value="0">Dừng hoạt động</option>
                                        </select>
                                </div>
                            </div> --}}

                        </div>
                        <div class="mt-3 ms-auto me-auto mb-2">
                            <button type="submit" class="btn btn-success">Gửi</button>
                            <a href="{{ route('admin.index') }}" class="btn btn-warning">Quay lại</a>
                        </div>
                    </div>


                </form>
            </div><!--end col-->
        </div>
    @endsection
