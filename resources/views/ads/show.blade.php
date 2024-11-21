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
            <div class="card-header">
                <h4 class="mb-0">Thông tin dịch vụ</h4>
            </div>
            <div class="card-body">
                <div>
                    <label for="basiInput" class="form-label">Mã dịch vụ</label>
                    <input type="text" class="form-control mb-3" id="basiInput" name="name"
                        value="#{{ $ads->id }}" disabled>

                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <label for="basiInput" class="form-label">Phương thức thanh toán</label>
                        <input type="text" class="form-control mb-3" id="basiInput" name="name"
                        value = "Thanh toán qua VNPay" disabled >
                      

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
                            <th>STT</th>
                            <th>Tiêu đề</th>
                            <th>Nội dung</th>
                            <th>Hình ảnh</th>
                            <th>Đường dẫn</th>
                            <th>Thời gian thay đổi</th>
                        </tr>
                    </thead>
                    <tbody>
                   @foreach($config as $index => $value)
                        <tr>
                            <td>{{$index + 1}}</td>
                            <td>{{$value->title}}</td>
                            <td>{{$value->highlight}}</td>
                            <td>{{$value->image}}</td>
                            <td>{{$value->url}}</td>
                            <td>{{$value->created_at}}</td>
                        </tr>
                        
                    @endforeach
                    </tbody>
                </table>

              
                </div>
               

            </div>
        </div>

        <div class="card mt-2">
            @if($ads->status ==1)

                <div class="card-header">
                <h4 class="mb-0">Thay đổi trạng thái đơn hàng</h4>
        </div>
     
        @endif
        @if($ads->status == 2)
        <div class="mt-3 text-center mb-2">
            <a href="{{ route('ads_service.index') }}" class="btn btn-success">Quay lại</a>

        </div>
        @endif
    </div>
</div>
@endsection