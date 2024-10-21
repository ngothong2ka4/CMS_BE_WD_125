<div class="card-header">
    <h5 class="card-title mb-0">Quản lý loại đá</h5>
</div>
<div class="card-body">
    <a href="{{ route('stone.create') }}"><button class="btn btn-secondary mb-2">Thêm mới</button></a>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <table id="example1" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
        <thead>
            <tr>
                <th>Stt</th>
                <th>Tên đá</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($stones as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->name }}</td>
                    <td>
                        <a href="{{ route('stone.update', $item->id) }}"><button
                                class="btn btn-warning me-3">Sửa</button></a>
                        <form action="{{ route('stone.destroy', $item->id) }}" method="POST" class="d-inline"
                            onsubmit="return confirm('Bạn có đồng ý xóa không?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger">Xóa</button>
                        </form>
                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>
</div>

@push('scripts')
    <script>
        new DataTable("#example1", {
            order: [
                [0, 'asc']
            ],
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