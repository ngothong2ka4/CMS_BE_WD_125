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

            <form>
                @csrf
                <div class="card mb-2">
                    <div class="card-header">
                        <h4 class="mb-0">Thông tin tài khoản</h4>
                    </div>
                    <div class="card-body">
                        <div class="profile-container d-flex gap-3">
                            <div class="profile-image">
                                @if ($user->image)
                                    <img class="rounded-circle" src="{{ $user->image }}" width="200px" height="200px"
                                    alt="Avatar">
                                @endif
                                @if (Auth::id() === $user->id)
                                    <div class="text-center ">
                                        <a href="{{ route('admin.edit', Auth::user()->id) }}" class="btn btn-white ">Chỉnh
                                            sửa</a>
                                    </div>
                                @endif
                            </div>
                            <div class="profile-info m-5">
                                <h1>{{ $user->name }}</h1>
                            </div>
                        </div>
                        <div class="">
                       
                            <li class="d-flex m-3 "> <strong class="col-2"> Tên: </strong><input type="text" class="form-control w-50"
                                    value="{{ $user->name }}" disabled> </li>

                            @if ($user->phone_number)
                                <li class="d-flex m-3"> <strong class="col-2"> Số điện thoại:</strong><input type="text" class="col-6 form-control w-50 "
                                        value="{{ $user->phone_number }}" disabled> </li>
                            @endif

                            <li class="d-flex m-3"> <strong class="col-2"> Email: </strong><input type="text" class="col-6 form-control w-50 "
                                    value="{{ $user->email }}" disabled> </li>

                            @if ($user->address)
                                <li class="d-flex m-3"> <strong class="col-2">Địa chỉ: </strong><input type="text" class="col-6 form-control w-50 "
                                        value="{{ $user->address }}" disabled> </li>
                            @endif

                            <li class="d-flex m-3"> <strong class="col-2">Quyền: </strong><input type="text" class="col-6 form-control w-50 "
                                    value="{{ $user->role == 2 ? 'Admin' : 'User' }}" disabled> </li>


                            <li class="d-flex m-3"> <strong class="col-2"> Trang thái: </strong><input type="text" class="col-6 form-control w-50 "
                                    value="{{ $user->status == 1 ? 'Hoạt động' : 'Dừng hoạt động' }}" disabled> </li>


                        </div>
                    </div>
                    <div class="mt-3 ms-auto me-auto mb-2">
                        <a href="{{ route('admin.index') }}" class="btn btn-success">Quay lại</a>
                    </div>
                </div>


            </form>
        </div><!--end col-->
    </div>
@endsection
