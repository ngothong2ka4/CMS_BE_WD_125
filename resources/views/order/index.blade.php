@extends('layouts.app-theme')


@push('scripts')
     
@endpush

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Quản lý đơn hàng</h5>
                </div>
                <div class="card-body">
              
                    <table id="example"
                        class="table table-bordered dt-responsive nowrap table-striped align-middle"
                        style="width:100%">
                        <thead>
                        <tr>
                            <th >Mã đơn hàng</th>
                            <th >Tên khách hàng</th>
                            <th >Tổng tiền</th>
                            <th >Trạng thái đơn hàng</th>
                            <th >Trạng thái thanh toán</th>
                            <th >Hành động</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $index => $order)
                                <tr>
                                    <td>#{{ $order->id }}</td>
                                    <td>{{ $order->recipient_name }}</td>   
                                    <td>{{ number_format($order->total_payment) }}</td>

                                    <td>{{ $order->	status }}</td>
                                    <td>{{ $order->	status_payment }}</td>                            
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
            order: [ [0, 'desc'] ] ,
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
