@extends('layouts.app-theme')


@push('scripts')
     
@endpush

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Quản lý Voucher</h5>
                </div>
                <div class="card-body">
                    <a href="{{ route('voucher.create') }}"><button class="btn btn-secondary mb-2">Thêm mới</button></a>
                    <table id="example"
                        class="table table-bordered dt-responsive nowrap table-striped align-middle"
                        style="width:100%">
                        <thead>
                        <tr>
                            <th >STT</th>
                            {{-- <th >Tên sản phẩm</th> --}}
                            <th >Mã Code</th>
                            <th >Tên</th>
                            <th >Mức ưu đãi</th>
                            <th >Ngày bắt đầu</th>
                            <th>Ngày kết thúc</th>
                            <th>Lượt dùng/Giới hạn</th>
                            <th >Hành động</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($vouchers as $index => $voucher)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    {{-- <td>{{ $voucher->id_product ?$voucher->product->name :' ' }}</td> --}}
                                    <td>{{ $voucher->code }}</td>
                                    <td>{{ $voucher->title }}</td>
                                    <td>{{$voucher->discount_type==1 ? $voucher->discount_value ."%":$voucher->discount_value."đ" }}</td>
                                    <td>{{ \Carbon\Carbon::parse($voucher->start_date)->format('d-m-Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($voucher->end_date)->format('d-m-Y') }}</td>
                                    <td>{{$voucher->usage_limit}} / {{$voucher->usage_per_user}}</td>
                                    <td>                                        
                                        <a href="{{ route('voucher.show', $voucher->id) }}"><button class="btn btn-info">Chi tiết</button></a>
                                        <a href="{{ route('voucher.edit', $voucher->id) }}"><button class="btn btn-warning">Sửa</button></a>
                                        
                                            <form action="{{ route('voucher.destroy', $voucher->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</button>
                                            </form>
                                    </td>
                                </tr>
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
