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
                        <option value="1" {{request('status') == 1 ?'selected' : '' }}>Hoạt động</option>
                        <option value="2" {{request('status') == 2 ?'selected' : '' }}>Dừng hoạt động</option>
                    </select>
                </form>

            </div>
            <div class="card-body">

                <table id="example"
                    class="table table-bordered dt-responsive nowrap table-striped align-middle"
                    >
                    <thead>
                        <tr>
                            <th>Mã</th>
                            <th>Tên khách hàng</th>
                            <th>Thời hạn</th>
                            <th>Lượt truy cập</th>
                            <th>Thành tiền</th>
                            <th>Trạng thái dịch vụ</th>
                            <th>Trạng thái thanh toán</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($adss as $index => $ads)
                        <tr>
                            <td>{{ $ads->id }}</td>
                            <td>{{ $ads->name }}</td>
                            <td>Từ {{$ads->start }} -> {{$ads->end}}</td>
                            <td>{{$ads->visits}}</td>
                            <td>{{ number_format($ads->price) }} đ</td>

                            <td>
                                @if($ads-> status == 1)
                                Hoạt động
                                @endif
                                @if($ads-> status == 2)
                                Dừng hoạt động
                                @endif
                                
                            </td>
                            <td>
                                @if($ads-> status_payment == 1)
                                Chưa thanh toán
                                @endif
                                @if($ads-> status_payment == 2)
                                Đã thanh toán
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('ads_service.show', $ads->id) }}"><button class="btn btn-info">Chi tiết</button></a>
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