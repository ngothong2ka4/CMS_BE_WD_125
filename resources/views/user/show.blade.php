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

            <form action="" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card mb-2">
                    {{-- <div class="card-header">
                        <h4 class="mb-0">Thông tin tài khoản</h4>
                    </div> --}}
                    <div class="card-body">
                        <div class="profile-container d-flex gap-3">
                            <div class="profile-image">
                                <img class="rounded-circle" src="{{ $user->image }}" width="200px" height="200px"
                                    alt="Avatar">
                            </div>
                            <div class="profile-info m-5">
                                <h1>{{ $user->name }}</h1>
                            </div>
                        </div>
                        <div class="">
                            <h2>Thông tin cá nhân</h2>
                            <li> <strong> Tên: </strong>{{ $user->name }} </li>
                            <li> <strong> Số điện thoại:</strong> {{ $user->phone_number }} </li>
                            <li> <strong> Email: </strong>{{ $user->email }} </li>
                            <li> <strong>Địa chỉ: </strong> {{ $user->address }} </li>
                            <li> <strong>Quyền: </strong>{{ $user->role == 2 ? 'Admin' : 'User' }} </li>
                            <li> <strong> Trang thái: </strong>{{ $user->status == 1 ? 'Hoạt động' : 'Dừng hoạt động' }} </li>
                        </div>
                    </div>
                    <div class="mt-3 ms-auto me-auto mb-2">
                        <a href="{{ route('user.index') }}" class="btn btn-success">Quay lại</a>
                    </div>
                </div>


            </form>
        </div><!--end col-->
    </div>
@endsection
