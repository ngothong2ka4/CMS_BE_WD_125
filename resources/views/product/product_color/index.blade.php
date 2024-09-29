@extends('layouts.app-theme')


@push('scripts')
     
@endpush

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Quản lý màu sắc sản phẩm</h5>
                </div>
                <div class="card-body">
                    <a href="{{ route('product_color.create') }}"><button class="btn btn-secondary mb-2">Thêm mới</button></a>
                    <table id="example"
                        class="table table-bordered dt-responsive nowrap table-striped align-middle"
                        style="width:100%">
                        <thead>
                        <tr>
                            <th data-ordering="false">SR No.</th>
                            <th data-ordering="false">ID</th>
                            <th>Assigned To</th>
                            <th>Created By</th>
                            <th>Create Date</th>
                            <th>Status</th>
                            <th>Priority</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>01</td>
                            <td>VLZ-452</td>
                            <td>Alexis Clarke</td>
                            <td>Joseph Parker</td>
                            <td>03 Oct, 2021</td>
                            <td><span class="badge bg-info-subtle text-info">Re-open</span></td>
                            <td><span class="badge bg-danger">High</span></td>
                            <td>
                                <a href=""><button class="btn btn-warning">Sửa</button></a>
                                <button class="btn btn-danger">Xoá</button>
                            </td>
                        </tr>
   
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
