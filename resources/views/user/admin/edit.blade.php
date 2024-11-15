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
            
            <form action="{{ route('admin.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card mb-2">
                    <div class="card-header">
                        <h4 class="mb-0">Thông tin tài khoản</h4>
                    </div>
                    <div class="card-body">
                        <div class="profile-container d-flex gap-3">
                            <div class="profile-image">
                                <img class="rounded-circle" src="{{ $user->image }}" width="200px" height="200px"
                                    alt="Avatar">

                                <div class="text-center ">
                                    <input type="file" name="image">
                                </div>

                            </div>
                            <div class="profile-info m-5">
                                <h1>{{ $user->name }}</h1>
                            </div>
                        </div>
                        <div class="">

                            <div class="d-flex m-3 ">
                                <strong class="col-2"> Tên: </strong>
                                <input type="text" class="form-control w-50" name="name" value="{{ $user->name }}">
                            </div>

                            <div class="d-flex m-3">
                                <strong class="col-2"> Số điện thoại:</strong>
                                <input type="text" class="col-6 form-control w-50 " name="phone_number"
                                    value="{{ $user->phone_number }}">
                            </div>

                            <div class="d-flex m-3">
                                <strong class="col-2"> Email: </strong>
                                <input type="text" class="col-6 form-control w-50 " name="email"
                                    value="{{ $user->email }}">
                            </div>

                            <div class="d-flex m-3">
                                <strong class="col-2">Địa chỉ: </strong>
                                <input type="text" class="col-6 form-control w-50 " name="address"
                                    value="{{ $user->address }}">
                            </div>

                            <div class="d-flex m-3"> <strong class="col-2">Quyền: </strong>
                                <div>
                                    <select class="form-select mb-3" name="role" id="role">
                                        <option value="1"{{ $user->role == 1 ? 'selected' : ' ' }}>User</option>
                                        <option value="2"{{ $user->role == 2 ? 'selected' : ' ' }}>Admin</option>
                                    </select>
                                </div>
                            </div>

                            <div class="d-flex m-3"> <strong class="col-2"> Trang thái: </strong>
                                <div>
                                    <select class="form-select mb-3" name="status">
                                        <option value="1"{{ $user->status == 1 ? 'selected' : ' ' }}>Hoạt động</option>
                                        <option value="0"{{ $user->status == 0 ? 'selected' : ' ' }}>Dừng hoạt động
                                        </option>
                                    </select>
                                </div>
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
