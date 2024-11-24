@extends('layouts.app-theme')


@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card mb-1">
            <div class="card-header" style="background: transparent !important;">
                <h2 class="mb-0">Chi tiết dịch vụ </h2>
            </div>
        </div>


        <div class="card mb-2">
            <div class="card-header ">
                <div class="row">
                    <h4 class="mb-0 col-lg-10">Thông tin dịch vụ</h4>
                    @if($ads->status ==1)
                    <div class="col-lg-2">
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            Dừng hoạt động
                        </button>


                    </div>

                    @endif
                </div>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <form action="{{ route('ads_service.destroy', $ads->id) }}" class="modal-content" method="POST">
                        @csrf
                        @method('DELETE')
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Nhập ghi chú</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <textarea class="form-control" name="note" id="meassageInput" rows="3"></textarea>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                            <button type="submit" class="btn btn-primary">Lưu</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6">
                        <label for="basiInput" class="form-label">Mã dịch vụ</label>
                        <input type="text" class="form-control mb-3" id="basiInput" name="name"
                            value="#{{ $ads->id }}" disabled>
                    </div>
                    <div class="col-lg-6">
                        <label for="basiInput" class="form-label">Lượt truy cập</label>
                        <input type="text" class="form-control mb-3" id="basiInput" name="name"
                            value="{{$ads->visits}}"
                            disabled>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <label for="basiInput" class="form-label">Trạng thái</label>
                        <input type="text" class="form-control mb-3" id="basiInput" name="name"
                            @if($ads-> status == 1)
                        value=" Hoạt động"
                        @endif
                        @if($ads-> status == 2)
                        value=" Dừng hoạt động"
                        @endif disabled>
                    </div>
                    <div class="col-lg-6">
                        <label for="basiInput" class="form-label">Vị trí</label>
                        <input type="text" class="form-control mb-3" id="basiInput" name="name"
                            value="{{ $ads->location }}" disabled>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <label for="basiInput" class="form-label">Phương thức thanh toán</label>
                        <input type="text" class="form-control mb-3" id="basiInput" name="name"
                            value="Thanh toán qua VNPay" disabled>


                    </div>

                    <div class="col-lg-6">
                        <label for="basiInput" class="form-label">Trạng thái thanh toán</label>
                        <input type="text" class="form-control mb-3" id="basiInput" name="name"
                            @if($ads-> status_payment == 1)
                        value = "Chưa thanh toán"
                        @endif
                        @if($ads->status_payment == 2)
                        value = "Đã thanh toán"
                        @endif disabled>

                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <label for="basiInput" class="form-label">Tên khách hàng</label>
                        <input type="text" class="form-control mb-3" id="basiInput" name="name"
                            value="{{ $ads->name }}" disabled>

                    </div>

                    <div class="col-lg-6">
                        <label for="basiInput" class="form-label">Điện thoại</label>
                        <input type="text" class="form-control mb-3" id="basiInput"
                            value="{{ $ads->phone }}" disabled>

                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <label for="basiInput" class="form-label">Thời gian bắt đầu</label>
                        <input type="text" class="form-control mb-3" id="basiInput" name="name"
                            value="{{ $ads->start }}" disabled>

                    </div>

                    <div class="col-lg-6">
                        <label for="basiInput" class="form-label">Thời gian kết thúc</label>
                        <input type="text" class="form-control mb-3" id="basiInput"
                            value="{{ $ads->end }}" disabled>

                    </div>
                </div>
                <div class="">
                        <label for="basiInput" class="form-label">Đơn giá</label>
                        <input type="text" class="form-control mb-3" id="basiInput"
                            value="{{ number_format($ads->price, 0, '.', '')}} đ" disabled>

                    </div>
            </div>
        </div>
        <div class="card mt-2">
            <div class="card-header">
                <h4 class="mb-0">Chi tiết quảng cáo</h4>
            </div>
            <div class="card-body">
                <table id="example"
                    class="table table-badsed dt-responsive nowrap table-striped align-middle"
                    style="width:100%">
                    <thead>
                        <tr>
                           
                            <th>Tiêu đề</th>
                            <th>Nội dung</th>
                            <th>Hình ảnh</th>
                            <th>Đường dẫn</th>
                            <th>Thời gian thay đổi</th>
                        </tr>
                    </thead>
                    <tbody>
                    
                        <tr>
                            <td>{{$config->title}}</td>
                            <td>{{$config->highlight}}</td>
                            <td><img src="{{$config->image}}" alt="" width="100px"></td>
                            <td>{{$config->url}}</td>
                            <td>{{$config->created_at}}</td>
                        </tr>

                       
                    </tbody>
                </table>


            </div>



        </div>

        <div class="card mt-2">


            <div class="mt-3 text-center mb-2">
                <a href="{{ route('ads_service.index') }}" class="btn btn-success">Quay lại</a>

            </div>

        </div>
    </div>

    @endsection