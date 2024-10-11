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
                            value="{{ $order->payment_role }}" disabled>

                    </div>

                    <div class="col-lg-6">
                        <label for="basiInput" class="form-label">Trạng thái thanh toán</label>
                        <input type="text" class="form-control mb-3" id="basiInput" name="name"
                            value="{{ $order->status_payment }}" disabled>

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
                                <td>{{$orderhis->from_status}} --> {{$orderhis->to_status}} </td>
                                <td>{{$orderhis->note}}</td>
                                <td>{{$user->name}}</td>
                                <td>{{$orderhis->created_at}}</td>
                            </tr>
                    @endforeach
                    </tbody>
                </table>


            </div>
        </div>
        <div class="card mt-2">
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
                            @if($order->status == 'Chờ xác nhận')
                            <option value="Đã xác nhận">Đã xác nhận</option>
                            <option value="Đã hủy">Hủy</option>
                            @endif
                            @if($order->status == 'Đã xác nhận')
                            <option value="Đang giao">Đang giao hàng</option>
                            @endif
                            @if($order->status == 'Đang giao')
                            <option value="Giao hàng thành công">Giao hàng thành công</option>
                            <option value="Giao hàng thất bại">Giao hàng thất bại</option>
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

        </div>
    </div>
    @endsection