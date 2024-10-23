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
                    <h2 class="mb-0">Thông tin chi tiết bình luận</h2>
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
                        <div>
                            <label for="basiInput" class="form-label">Tên sản phẩm</label>
                            <input type="text" class="form-control" id="basiInput" name="id_product"
                                value="{{ $comment->product->name }}" disabled>

                        </div>
                        <div>
                            <label for="basiInput" class="form-label">Tên người dùng</label>
                            <input type="text" class="form-control" id="basiInput" name="id_user"
                                value="{{ $comment->user->name }}" disabled>

                        </div>
                        <div>
                            <label for="basiInput" class="form-label">Nội dung</label>
                            <input type="text" class="form-control" id="basiInput" name="content"
                                value="{{ $comment->content }}" disabled>

                        </div>
                        <div>
                            <label for="basiInput" class="form-label">Đánh giá</label>
                            <input type="text" class="form-control" id="basiInput" name="rating"
                                value="{{ $comment->rating }}" disabled>

                        </div>
                        <div>
                            <label for="basiInput" class="form-label">Trang thái</label>
                            <input type="text" class="form-control" id="basiInput" name="status"
                                value="{{ $comment->status ? 'Kích hoạt' : 'Dừng kích hoạt' }}" disabled>
                        </div>
                        
                    </div><div class="mt-3 ms-auto me-auto mb-2">
                            <a href="{{ route('comment.index') }}" class="btn btn-success">Quay lại</a>
                        </div>
                </div>


            </form>
        </div><!--end col-->
    </div>
@endsection
