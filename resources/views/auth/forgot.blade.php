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
                        <h5 class="text-primary">Quên mật khẩu? </h5>
                        {{-- <p class="text-muted">Reset password with velzon</p> --}}

                        <lord-icon src="https://cdn.lordicon.com/rhvddzym.json" trigger="loop" colors="primary:#0ab39c"
                            class="avatar-xl"></lord-icon>

                    </div>

                    <div class="alert border-0 alert-warning text-center mb-2 mx-2" role="alert">
                        Nhập email của bạn và hướng dẫn sẽ được gửi đến bạn!
                    </div>
                    <div class="p-2">
                        <form>
                            <div class="mb-4">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" id="email"
                                    placeholder="Nhập email của bạn...">
                            </div>

                            <div class="text-center mt-4">
                                <button class="btn btn-success w-100" type="submit">Gửi</button>
                            </div>
                        </form><!-- end form -->
                    </div>
                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->

            <div class="mt-4 text-center">
                @auth
                    <p class="mb-0">Quay lại..<a href="{{ route('changePassword',Auth::user()->id) }}"
                            class="fw-semibold text-primary text-decoration-underline">Tại đây. </a> </p>
                @endauth
                @guest
                    <p class="mb-0">Nhập mật khẩu...<a href="{{ route('login') }}"
                        class="fw-semibold text-primary text-decoration-underline">Tại đây. </a> </p>
                @endguest
                
            </div>

        </div>
    </div>
    <!-- end row -->
@endsection
