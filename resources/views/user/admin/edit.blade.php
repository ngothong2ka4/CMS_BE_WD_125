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
                    {{-- <div class="card-header">
                        <h4 class="mb-0">Thông tin tài khoản</h4>
                    </div> --}}
                    <div class="card-body">
                        <div>
                            <label for="basiInput" class="form-label">Tên người dùng</label>
                            <input type="text" class="form-control" id="basiInput" name="name"
                                value="{{ $user->name }}">

                        </div>
                        <div>
                            <label for="basiInput" class="form-label">Ảnh Avatar</label>
                            <input type="file" name="image" class="form-control">
                            <img class="mb-3 pl-5" src="{{ $user->image }}" width=100 height=100 alt="">
                        </div>
                        <div>
                            <label for="basiInput" class="form-label">Số điện thoại</label>
                            <input type="phone" class="form-control" id="basiInput" name="phone_number"
                                value="{{ $user->phone_number }}">

                        </div>
                        <div>
                            <label for="basiInput" class="form-label">Email</label>
                            <input type="email" class="form-control" id="basiInput" name="email"
                                value="{{ $user->email }}">

                        </div>
                        <div>
                            <label for="basiInput" class="form-label">Địa chỉ</label>
                            <input type="text" class="form-control" id="basiInput" name="address"
                                value="{{ $user->address }}">

                        </div>
                        <div class="d-flex gap-2">
                            <div>
                                <label for="basiInput" class="form-label">Quyền</label>
                                <select class="form-select mb-3" name="role" id="role">
                                    <option value="1"{{ $user->role == 1 ? 'selected' : ' ' }}>User</option>
                                    <option value="2"{{ $user->role == 2 ? 'selected' : ' ' }}>Admin</option>
                                </select>
                            </div>
                            <div>
                                <label for="basiInput" class="form-label">Trang thái</label>
                                <select class="form-select mb-3" name="status">
                                    <option value="1"{{ $user->status == 1 ? 'selected' : ' ' }}>Hoạt động</option>
                                    <option value="0"{{ $user->status == 0 ? 'selected' : ' ' }}>Dừng hoạt động
                                    </option>
                                </select>
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
