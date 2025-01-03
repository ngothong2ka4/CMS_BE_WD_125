@extends('layouts.guest')

@section('content')
    <!-- end row -->

    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 col-xl-5">
            <div class="card mt-4">

                <div class="card-body p-4">
                    <div class="text-center mt-2">
                        <h5 class="text-primary">Xin chào !</h5>
                        <p class="text-muted">Đăng Nhập Ngay.</p>
                    </div>
                    <div class="">
                        @if ($errors->has('login'))
                            <div class="invalid-feedback d-block">
                                {{ $errors->first('login') }}
                            </div>
                        @endif
                    </div>
                    <div class="p-2 mt-4">
                        <form action="{{ route('login') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control  @error('email') is-invalid @enderror"
                                    id="email" name="email" placeholder="Email" value="{{ old('name') }}">
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
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
                            <div class="form-check mb-3 float-start">
                                {{-- <input class="form-check-input" type="checkbox" name="remember" id="auth-remember-check">
                                <label class="form-check-label" for="auth-remember-check">Nhớ mật khẩu</label> --}}
                            </div>
                            <div class="float-end mb-3">
                                <a href="{{ route('forgot') }}" class="text-muted ">Quên mật khẩu?</a>
                            </div>
                            <div class="mt-4">
                                <button class="btn btn-success w-100" type="submit">Đăng Nhập</button>
                            </div>

                            {{-- <div class="mt-4 text-center">
                                <div class="signin-other-title">
                                    <h5 class="fs-13 mb-4 title">Đăng Nhập với</h5>
                                </div>
                                <div>
                                    <button type="button" class="btn btn-primary btn-icon waves-effect waves-light"><i
                                            class="ri-facebook-fill fs-16"></i></button>
                                    <button type="button" class="btn btn-danger btn-icon waves-effect waves-light"><i
                                            class="ri-google-fill fs-16"></i></button>
                                    <button type="button" class="btn btn-dark btn-icon waves-effect waves-light"><i
                                            class="ri-github-fill fs-16"></i></button>
                                    <button type="button" class="btn btn-info btn-icon waves-effect waves-light"><i
                                            class="ri-twitter-fill fs-16"></i></button>
                                </div>
                            </div> --}}
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
