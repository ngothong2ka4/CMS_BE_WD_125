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
                    <a href="{{ route('product_management.create') }}"><button class="btn btn-secondary mb-2">Thêm mới</button></a>
                    <table id="example"
                        class="table table-bordered dt-responsive nowrap table-striped align-middle"
                        style="width:100%">
                        <thead>
                        <tr>
                            <th >No</th>
                            <th >Màu sắc sản phẩm</th>
                            <th >Ngày tạo</th>
                            <th >Ngày cập nhật</th>
                            <th >Hành động</th>
                        </tr>
                        </thead>
                        <tbody>
                            {{-- @foreach ($productColors as $productColor)
                                <tr>
                                    <td>{{ $productColor->id }}</td>
                                    <td>{{ $productColor->name }}</td>
                                    <td>{{ $productColor->created_at }}</td>
                                    <td>{{ $productColor->updated_at }}</td>
                                    <td>
                                        <a href="{{ route('product_color.edit', $productColor->id) }}"><button class="btn btn-warning">Sửa</button></a>
                                        
                                            <form action="{{ route('product_color.destroy', $productColor->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</button>
                                            </form>
                                    </td>
                                </tr>
                            @endforeach --}}
   
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
