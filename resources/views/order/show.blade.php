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
                <h2 class="mb-0">Chi tiết đơn hàng</h2>
            </div>
        </div>


        <div class="card mb-2">
            <div class="card-header">
                <h4 class="mb-0">Thông đơn hàng</h4>
            </div>
            <div class="card-body">
                <div>
                    <label for="basiInput" class="form-label">Mã đơn hàng</label>
                    <input type="text" class="form-control mb-3" id="basiInput" name="name"
                        value="#{{ $order->id }}" disabled>

                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <label for="basiInput" class="form-label">Phương thức thanh toán</label>
                        <input type="text" class="form-control mb-3" id="basiInput" name="name"
                        @if($order->	status_payment == 1)
                                       value = "Thanh toán khi nhận hàng"
                                        @endif
                                        @if($order->status_payment == 2)
                                       value = "Thanh toán qua VNPay"
                                        @endif 
                                        @if($order->status_payment == 3)
                                       value = "Thanh toán qua Momo"
                                        @endif disabled>

                    </div>

                    <div class="col-lg-6">
                        <label for="basiInput" class="form-label">Trạng thái thanh toán</label>
                        <input type="text" class="form-control mb-3" id="basiInput" name="name"
                            @if($order->	status_payment == 1)
                                       value = "Chưa thanh toán"
                                        @endif
                                        @if($order->status_payment == 2)
                                       value = "Đã thanh toán"
                                        @endif disabled>

                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <label for="basiInput" class="form-label">Tên khách hàng</label>
                        <input type="text" class="form-control mb-3" id="basiInput" name="name"
                            value="{{ $order->recipient_name }}" disabled>

                    </div>

                    <div class="col-lg-6">
                        <label for="basiInput" class="form-label">Điện thoại</label>
                        <input type="text" class="form-control mb-3" id="basiInput" 
                            value="{{ $order->phone_number }}" disabled>

                    </div>
                </div>
                <div>
                    <label for="basiInput" class="form-label">Địa chỉ</label>
                    <input type="text" class="form-control mb-3" id="basiInput" 
                        value="{{ $order->	recipient_address}}" disabled>

                </div>

            </div>
        </div>
        <div class="card mt-2">
            <div class="card-header">
                <h4 class="mb-0">Thông tin sản phẩm</h4>
            </div>
            <div class="card-body">
                <table id="example"
                    class="table table-bordered dt-responsive nowrap table-striped align-middle"
                    style="width:100%">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Tên sản phẩm</th>
                            <th>Biến thể</th>
                            <th>Số lượng</th>
                            <th>Giá bán</th>
                            <th>Thành tiền</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orderdetails as $index => $orderdetail)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $orderdetail->product_name }}</td>
                            <td>Màu: {{ $orderdetail->orderVariant?->color->name}}, Size: {{ $orderdetail->orderVariant?->size->name}}</td>

                            <td>{{ $orderdetail->	quantity }}</td>
                            <td>{{ number_format($orderdetail->	selling_price) }}</td>
                            <td>{{number_format($orderdetail->	quantity * $orderdetail->	selling_price) }}</td>
                        </tr>

                        @endforeach

                    </tbody>
                </table>
                <div class="col-lg-12 text-center font-weight-bold">
                    <h5>Tổng: {{number_format($order->total_payment)}}</h5>
                </div>

            </div>
        </div>
        <div class="card mt-2">
            <div class="card-header">
                <h4 class="mb-0">Lịch sử thay đổi trạng thái</h4>
            </div>
            <div class="card-body">
                <table id="example"
                    class="table table-bordered dt-responsive nowrap table-striped align-middle text-center"
                    style="width:100%">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Trạng thái thay đổi</th>
                            <th>Ghi chú</th>
                            <th>Người thay đổi</th>
                            <th>Thời gian</th>


                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($orderhistories as $index => $orderhis)
                            <tr>
                                <td>{{$index + 1}}</td>
                                <td>@if($orderhis->from_status == 1)
                                        Chờ xác nhận
                                        @endif
                                        @if($orderhis->from_status == 2)
                                        Đã xác nhận
                                        @endif
                                        @if($orderhis->from_status == 3)
                                        Đang giao
                                        @endif
                                        @if($orderhis->from_status == 4)
                                        Giao hàng thành công
                                        @endif
                                        @if($orderhis->from_status == 5)
                                        Giao hàng thất bại
                                        @endif
                                        @if($orderhis->from_status == 6)
                                        Hoàn thành
                                        @endif
                                        @if($orderhis->from_status == 7)
                                        Đã hủy
                                        @endif
                                     --> 
                                        @if($orderhis->to_status == 1)
                                        Chờ xác nhận
                                        @endif
                                        @if($orderhis->to_status == 2)
                                        Đã xác nhận
                                        @endif
                                        @if($orderhis->to_status == 3)
                                        Đang giao
                                        @endif
                                        @if($orderhis->to_status == 4)
                                        Giao hàng thành công
                                        @endif
                                        @if($orderhis->to_status == 5)
                                        Giao hàng thất bại
                                        @endif
                                        @if($orderhis->to_status == 6)
                                        Hoàn thành
                                        @endif
                                        @if($orderhis->to_status == 7)
                                        Đã hủy
                                        @endif </td>
                                <td>{{$orderhis->note}}</td>
                                <td>{{$orderhis->idUser?->name}}
                                    @if($orderhis->id_user == 0)
                                        Hệ thống
                                    @endif
                                </td>
                                <td>{{$orderhis->created_at}}</td>
                            </tr>
                    @endforeach
                    </tbody>
                </table>


            </div>
        </div>
        <div class="card mt-2">
        @if($order->status <=3)

            <div class="card-header">
                <h4 class="mb-0">Thay đổi trạng thái đơn hàng</h4>
            </div>
            <form action="{{ route('order.update', $order->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div>
                        <label for="basiInput" class="form-label">Trạng thái</label>
                        <select name="to_status" class="form-select mb-3" aria-label="Default select example">
                            <option value="">Chọn trạng thái</option>
                            @if($order->status == 1)
                            <option value="2">Đã xác nhận</option>
                            <option value="7">Hủy</option>
                            @endif
                            @if($order->status == 2)
                            <option value="3">Đang giao hàng</option>
                            @endif
                            @if($order->status == 3)
                            <option value="4">Giao hàng thành công</option>
                            <option value="5">Giao hàng thất bại</option>
                            @endif
                        </select>

                    </div>
                    <div>
                        <label for="basiInput" class="form-label">Ghi chú</label>
                        <textarea class="form-control" name="note" id="meassageInput" rows="3" placeholder="Nhập ghi chú"></textarea>
                    </div>

                    <div class="mt-3 text-center mb-2">
                        <a href="{{ route('order.index') }}" class="btn btn-success">Quay lại</a>
                        <button class="btn btn-primary" type="submit">Lưu</button>
                    </div>
            </form>
        @endif
        @if($order->status >=4)
        <div class="mt-3 text-center mb-2">
                        <a href="{{ route('order.index') }}" class="btn btn-success">Quay lại</a>
                   
                    </div>
        @endif
        </div>
    </div>
    @endsection