@extends('layouts.guest')

@section('content')
    <!-- end row -->

    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 col-xl-5">
            <div class="card mt-4">

                <div class="card-body p-4">
                    <div class="text-center mt-2">
                        <h5 class="text-primary">Xin chào !</h5>
                        <p class="text-muted">Tạo mật khẩu mới.</p>
                    </div>
                    <div class="p-2 mt-4">
                        <form action="" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label" for="password">Mật khẩu</label>
                                <div class="position-relative auth-pass-inputgroup mb-3">
                                    <input type="password"
                                        class="form-control pe-5 password-input @error('password') is-invalid @enderror"
                                        placeholder="Mật khẩu" id="password" name="password">
                                    <button
                                        class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon"
                                        type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                                    @error('password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        
                            <div class="mb-3">
                                <label class="form-label" for="password">Nhập lại mật khẩu</label>
                                <div class="position-relative auth-pass-inputgroup">
                                    <input type="password" class="form-control pe-5 password-input" onpaste="return false"
                                        placeholder=" Nhập mật khẩu" name="password_confirmation" id="password_confirmation"
                                        aria-describedby="passwordInput" 
                                        >
                                    <button
                                        class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon"
                                        type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                                    <div class="invalid-feedback">
                                        Nhập lại mật khẩu
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4">
                                <button class="btn btn-success w-100" type="submit">Gửi</button>
                            </div>


                        </form>

                    </div>
                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->

            {{-- <div class="mt-4 text-center">
                <p class="mb-0">Bạn chưa có tài khoản ? <a href="{{ route('signup') }}" class="fw-semibold text-primary text-decoration-underline"> Đăng Ký ngay </a> </p>
            </div> --}}

        </div>
    </div>
    <!-- end row -->
@endsection
