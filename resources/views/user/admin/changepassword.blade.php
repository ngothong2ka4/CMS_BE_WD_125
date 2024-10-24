@extends('layouts.guest')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="text-center mt-sm-5 mb-4 text-white-50">
            <div>
                <a href="index.html" class="d-inline-block auth-logo">
                    <img src="assets/images/logo-light.png" alt="" height="20">
                </a>
            </div>
            {{-- <p class="mt-3 fs-15 fw-medium">Premium Admin & Dashboard Template</p> --}}
        </div>
    </div>
</div>
<!-- end row -->

<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6 col-xl-5">
        <div class="card mt-4">

            <div class="card-body p-4">
                <div class="text-center mt-2">
                    <h5 class="text-primary">Đổi mật khẩu</h5>
                    {{-- <p class="text-muted">Reset password with velzon</p> --}}

                    {{-- <lord-icon src="https://cdn.lordicon.com/rhvddzym.json" trigger="loop" colors="primary:#0ab39c" class="avatar-xl"></lord-icon> --}}

                </div>

                {{-- <div class="alert border-0 alert-warning text-center mb-2 mx-2" role="alert">
                    Nhập email của bạn và hướng dẫn sẽ được gửi đến bạn!
                </div> --}}
                <div class="p-2">
                    <form action="{{ route('changePassword', $user->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        {{-- @method('PUT') --}}
                        <div class="card mb-2">
                            {{-- <div class="card-header">
                                <h4 class="b-0">Thông tin tài khoản</h4>
                            </div> --}}
                            <div class="card-body">
                                <div class="mmb-3">
                                    <label class="form-label" for="password">Nhập lại mật khẩu cũ</label>
                                    <div class="position-relative auth-pass-inputgroup">
                                        <input type="password" class="form-control pe-5 password-input"
                                            placeholder=" Nhập mật khẩu cũ" name="old_password" id="old_password"
                                            aria-describedby="passwordInput" value="{{ old('old_password') }}">
                                        <button
                                            class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon"
                                            type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                                        @error('old_password')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="password">Nhập mật khẩu mới</label>
                                    <div class="position-relative auth-pass-inputgroup">
                                        <input type="password" class="form-control pe-5 password-input"
                                            placeholder=" Nhập mật khẩu mới" name="new_password" id="new_password"
                                            aria-describedby="passwordInput" value="{{ old('new_password') }}">
                                        <button
                                            class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon"
                                            type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                                        @error('old_password')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="password">Nhập lại mật khẩu</label>
                                    <div class="position-relative auth-pass-inputgroup">
                                        <input type="password" class="form-control pe-5 password-input"
                                            placeholder=" Nhập lại mật khẩu " name="new_password_confirmation"
                                            id="new_password_confirmation" aria-describedby="passwordInput"
                                            value="{{ old('new_password_confirmation') }}">
                                        <button
                                            class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon"
                                            type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                                        @error('new_password_confirmation')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
        
                            </div>
                            <div class="float-end">
                                <a href="{{ route('forgot') }}" class="text-muted">Quên mật khẩu?</a>
                            </div>
                            <div class="mt-3 ms-auto me-auto mb-2">
                                <button type="submit" class="btn btn-success">Gửi</button>
                                {{-- <a href="{{ route('admin.index') }}" class="btn btn-warning">Quay lại</a> --}}
                            </div>
                        </div>
        
        
                    </form>
                </div>
            </div>
            <!-- end card body -->
        </div>
        <!-- end card -->

        <div class="mt-4 text-center">
            <p class="mb-0"><a href="{{ route('statistic.index') }}" class="fw-semibold text-primary text-decoration-underline">Quay lại </a> </p>
        </div>

    </div>
</div>
<!-- end row -->
@endsection
