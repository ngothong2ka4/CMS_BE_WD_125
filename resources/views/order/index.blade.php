@extends('layouts.app-theme')


@push('scripts')

@endpush

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header row">
                <h5 class="card-title mb-0 col-lg-9">Quản lý đơn hàng</h5>
                <form class="col-lg-3">
                    <select name="status" onchange="this.form.submit()" class=" form-select">
                        <option value="all" {{!request('status') || request('status') == 'all' ?'selected' : '' }}> Tất cả đơn hàng</option>
                        <option value="1" {{request('status') == 1 ?'selected' : '' }}>Chờ xác nhận</option>
                        <option value="2" {{request('status') == 2 ?'selected' : '' }}>Đã xác nhận</option>
                        <option value="3" {{request('status') == 3 ?'selected' : '' }}>Đang giao hàng</option>
                        <option value="4&6" {{request('status') == '4&6' ?'selected' : '' }}>Giao thành công</option>
                        <option value="5" {{request('status') == 5 ?'selected' : '' }}>Giao hàng thất bại</option>
                        <option value="7" {{request('status') == 7 ?'selected' : '' }}>Đã hủy</option>
                    </select>
                </form>

            </div>
            <div class="card-body">

                <table id="example"
                    class="table table-bordered dt-responsive nowrap table-striped align-middle"
                    style="width:100%">
                    <thead>
                        <tr>
                            <th>Mã đơn hàng</th>
                            <th>Tên khách hàng</th>
                            <th>Tổng tiền</th>
                            <th>Trạng thái đơn hàng</th>
                            <th>Trạng thái thanh toán</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $index => $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->recipient_name }}</td>
                            <td>{{ number_format($order->total_payment) }} đ</td>

                            <td>
                                @if($order-> status == 1)
                                Chờ xác nhận
                                @endif
                                @if($order-> status == 2)
                                Đã xác nhận
                                @endif
                                @if($order-> status == 3)
                                Đang giao
                                @endif
                                @if($order-> status == 4)
                                Giao hàng thành công
                                @endif
                                @if($order-> status == 5)
                                Giao hàng thất bại
                                @endif
                                @if($order-> status == 6)
                                Hoàn thành
                                @endif
                                @if($order-> status == 7)
                                Đã hủy
                                @endif

                            </td>
                            <td>
                                @if($order-> status_payment == 1)
                                Chưa thanh toán
                                @endif
                                @if($order-> status_payment == 2)
                                Đã thanh toán
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('order.show', $order->id) }}"><button class="btn btn-info">Chi tiết đơn hàng</button></a>
                            </td>
                            @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div><!--end col-->
</div>
@endsection

@push('scripts')
<script>
    new DataTable("#example", {
        order: [0, 'desc'],
        "language": {
            "sProcessing": "Đang xử lý...",
            "sLengthMenu": "Hiển thị _MENU_ mục",
            "sZeroRecords": "Không tìm thấy dữ liệu",
            "sInfo": "Hiển thị _START_ đến _END_ trong tổng số _TOTAL_ mục",
            "sInfoEmpty": "Hiển thị 0 đến 0 trong tổng số 0 mục",
            "sInfoFiltered": "(lọc từ _MAX_ mục)",
            "sSearch": "Tìm kiếm:",
            "sEmptyTable": "Không có dữ liệu",
            "sLoadingRecords": "Đang tải...",
            "oPaginate": {
                "sFirst": "Đầu tiên",
                "sLast": "Cuối cùng",
                "sNext": "Tiếp theo",
                "sPrevious": "Trước"
            }
        }
    });
</script>
@endpush