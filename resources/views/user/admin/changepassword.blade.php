<div>
    <!-- Do what you can, with what you have, where you are. - Theodore Roosevelt -->
</div>
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
                    <h2 class="mb-0">Đổi mật khẩu</h2>
                </div>
            </div>

            <form action="{{route('changePassword',$user->id)}}" method="POST" enctype="multipart/form-data">
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
                                <input type="password" class="form-control pe-5 password-input" placeholder=" Nhập mật khẩu cũ"
                                    name="current_password" id="current_password" aria-describedby="passwordInput"
                                    value="{{ old('password') }}">
                                <button
                                    class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon"
                                    type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>

                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="password">Nhập mật khẩu mới</label>
                            <div class="position-relative auth-pass-inputgroup">
                                <input type="password" class="form-control pe-5 password-input" placeholder=" Nhập mật khẩu mới"
                                    name="new_password" id="new_password" aria-describedby="passwordInput"
                                    value="{{ old('password_confirmation') }}">
                                <button
                                    class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon"
                                    type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>

                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="password">Nhập lại mật khẩu</label>
                            <div class="position-relative auth-pass-inputgroup">
                                <input type="password" class="form-control pe-5 password-input" placeholder=" Nhập lại mật khẩu "
                                    name="new_password_confirmation" id="new_password_confirmation"
                                    aria-describedby="passwordInput" value="{{ old('password_confirmation') }}">
                                <button
                                    class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon"
                                    type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>

                            </div>
                        </div>

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
