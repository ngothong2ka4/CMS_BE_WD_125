@extends('layouts.app-theme')


@section('content')
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
                    <div class="row">
                    <div class="col-lg-6">
                        <label for="basiInput" class="form-label">Mã đơn hàng</label>
                        <input type="text" class="form-control mb-3" id="basiInput" name="name"
                            value="#{{ $order->id }}" disabled>

                    </div>
                    <div class="col-lg-6">
                        <label for="basiInput" class="form-label">Trạng thái đơn hàng</label>
                        <input type="text" class="form-control mb-3" id="basiInput" name="name"
                            @if ($order ->status == 1)
                            value="Chờ xác nhận"
                                        @endif
                                        @if ($order ->status == 2)
                                        value="Đã xác nhận"
                                        @endif
                                        @if ($order ->status == 3)
                                        value="Đang giao"
                                        @endif
                                        @if ($order ->status == 4)
                                        value="Giao hàng thành công"
                                        @endif
                                        @if ($order ->status == 5)
                                        value="Giao hàng thất bại"
                                        @endif
                                        @if ($order ->status == 6)
                                        value="Hoàn thành"
                                        @endif
                                        @if ($order ->status == 7)
                                        value="Đã hủy"
                                        @endif
                                         disabled>

                    </div>
                    </div>
                  
                    <div class="row">
                        <div class="col-lg-6">
                            <label for="basiInput" class="form-label">Phương thức thanh toán</label>
                            <input type="text" class="form-control mb-3" id="basiInput" name="name"
                                @if ($order->payment_role == 1) value = "Thanh toán khi nhận hàng" @endif
                                @if ($order->payment_role == 2) value = "Thanh toán qua VNPay" @endif
                                @if ($order->payment_role == 3) value = "Thanh toán qua Momo" @endif disabled>

                        </div>

                        <div class="col-lg-6">
                            <label for="basiInput" class="form-label">Trạng thái thanh toán</label>
                            <input type="text" class="form-control mb-3" id="basiInput" name="name"
                                @if ($order->status_payment == 1) value = "Chưa thanh toán" @endif
                                @if ($order->status_payment == 2) value = "Đã thanh toán" @endif disabled>

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
                            value="{{ $order->recipient_address }}" disabled>

                    </div>

                </div>
            </div>
            <div class="card mt-2">
                <div class="card-header">
                    <h4 class="mb-0">Thông tin sản phẩm</h4>
                </div>
                <div class="card-body">
                    <table id="example" class="table table-bordered dt-responsive nowrap table-striped align-middle"
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
                            <?php
                            $tong = 0;
                            ?>
                            @foreach ($orderdetails as $index => $orderdetail)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $orderdetail->product_name }}</td>
                                    <td>Màu: {{ $orderdetail->orderVariant?->color->name }}, Kích thước:
                                        {{ $orderdetail->orderVariant?->size->name }}</td>

                                    <td>{{ $orderdetail->quantity }}</td>
                                    <td>{{ number_format($orderdetail->selling_price) }} đ</td>
                                    <td>{{ number_format($orderdetail->quantity * $orderdetail->selling_price) }} đ</td>
                                    <?php
                                    $tong += $orderdetail->quantity * $orderdetail->selling_price;
                                    ?>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>

                    <div class="row">
                        <div class="col-lg-7">

                        </div>
                        <div class="col-lg-5">
                            <div class="font-weight-bold  d-flex justify-content-around">
                                <p>Tổng tiền hàng:</p>
                                <p> {{ number_format($tong) }} đ</p>
                            </div>
                            @if ($order->discount_amount)
                                <div class="font-weight-bold  d-flex justify-content-around">
                                    <p>Mã giảm giá:</p>
                                    <p> -{{ number_format($order->discount_amount) }} đ</p>
                                </div>
                            @endif
                            @if ($order->used_accum)
                                <div class="font-weight-bold  d-flex justify-content-around">
                                    <p>Điểm tiêu dùng:</p>
                                    <p> -{{ number_format($order->used_accum * App\Models\Order::POINT_CONVERSION_VALUE) }}
                                        đ</p>
                                </div>
                            @endif
                            <hr>
                            <div class="font-weight-bold  d-flex justify-content-around">
                                <h5>Thành tiền:</h5>
                                <h5> {{ number_format($order->total_payment) }} đ</h5>
                            </div>
                        </div>

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
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        @if ($orderhis->from_status == 1)
                                            Chờ xác nhận
                                        @endif
                                        @if ($orderhis->from_status == 2)
                                            Đã xác nhận
                                        @endif
                                        @if ($orderhis->from_status == 3)
                                            Đang giao
                                        @endif
                                        @if ($orderhis->from_status == 4)
                                            Giao hàng thành công
                                        @endif
                                        @if ($orderhis->from_status == 5)
                                            Giao hàng thất bại
                                        @endif
                                        @if ($orderhis->from_status == 6)
                                            Hoàn thành
                                        @endif
                                        @if ($orderhis->from_status == 7)
                                            Đã hủy
                                        @endif
                                        -->
                                        @if ($orderhis->to_status == 1)
                                            Chờ xác nhận
                                        @endif
                                        @if ($orderhis->to_status == 2)
                                            Đã xác nhận
                                        @endif
                                        @if ($orderhis->to_status == 3)
                                            Đang giao
                                        @endif
                                        @if ($orderhis->to_status == 4)
                                            Giao hàng thành công
                                        @endif
                                        @if ($orderhis->to_status == 5)
                                            Giao hàng thất bại
                                        @endif
                                        @if ($orderhis->to_status == 6)
                                            Hoàn thành
                                        @endif
                                        @if ($orderhis->to_status == 7)
                                            Đã hủy
                                        @endif
                                    </td>
                                    <td>{{ $orderhis->note }}</td>
                                    <td>{{ $orderhis->idUser?->name }}
                                        @if ($orderhis->id_user == 0)
                                            Hệ thống
                                        @endif
                                    </td>
                                    <td>{{ $orderhis->created_at }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>


                </div>
            </div>
            <div class="card mt-2">
                @if ($order->status <= 3)
                    <div class="card-header">
                        <h4 class="mb-0">Thay đổi trạng thái đơn hàng</h4>
                    </div>
                    <form id="test-form">
                        @csrf
                        <!-- @method('PUT') -->
                        <div class="card-body">
                            <div>
                                <label for="basiInput" class="form-label">Trạng thái</label>
                                <select name="to_status" class="form-select mb-3" id="test-select"
                                    aria-label="Default select example">
                                    <option value="1" @if ($order->status ==1) selected @endif @if ($order->status >= 1) disabled @endif>Chờ xác nhận</option>

                                    <option value="2" @if ($order->status ==2) selected @endif  @if ($order->status >= 2) disabled @endif>Đã xác nhận
                                    </option>


                                    <option value="3" @if ($order->status ==3) selected @endif  @if ($order->status == 1 || $order->status >= 3) disabled @endif>Đang giao hàng
                                    </option>

                                    <option value="4" @if ($order->status <= 2) disabled @endif>Giao hàng
                                        thành công</option>
                                    <option value="5" @if ($order->status <= 2) disabled @endif>Giao hàng thất
                                        bại</option>
                                    <option value="7" @if ($order->status >= 2) disabled @endif>Hủy</option>


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
                @if ($order->status >= 4)
                    <div class="mt-3 text-center mb-2">
                        <a href="{{ route('order.index') }}" class="btn btn-success">Quay lại</a>

                    </div>
                @endif
            </div>
        </div>
        <script>
            $(document).ready(function() {
                $('#test-form').submit(function(e) {
                    e.preventDefault();
                    let timerInterval;
Swal.fire({
  title: "Đang tải!",
//   html: "I will close in <b></b> milliseconds.",
  timer: 5000,
  timerProgressBar: true,
  didOpen: () => {
    Swal.showLoading();
    const timer = Swal.getPopup().querySelector("b");
    timerInterval = setInterval(() => {
      timer.textContent = `${Swal.getTimerLeft()}`;
    }, 100);
  },
  willClose: () => {
    clearInterval(timerInterval);
  }
}).then((result) => {
  /* Read more about handling dismissals below */
  if (result.dismiss === Swal.DismissReason.timer) {
    console.log("I was closed by the timer");
  }
});
                    $.ajax({
                        url: '/order/{{ $order->id }}',
                        type: 'POST',
                        data: $('#test-form').serialize(),
                        success: function(res) {
                            
                            if (res.status) {
                                console.log(res.message);
                                Swal.fire({
                                    icon: "success",
                                    title: res.message,
                                }).then((result) => {
                                    window.location.reload();
                                });
                            }
                            if (res.error) {
                                console.log(res.error);
                                Swal.fire({
                                    icon: "error",
                                    title: res.error,
                                })
                            }

                        },
                        error: function(error) {
                            console.log(error);
                        }
                    })
                })
            })
        </script>
    @endsection
