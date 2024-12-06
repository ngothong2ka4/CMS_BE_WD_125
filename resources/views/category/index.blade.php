@extends('layouts.app-theme')


@push('scripts')
@endpush

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Quản lý danh mục</h5>
                </div>
                <div class="card-body">
                    <a href="{{ route('category.create') }}"><button class="btn btn-secondary mb-2">Thêm mới</button></a>
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <table id="example" class="table table-bordered dt-responsive nowrap table-striped align-middle"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th>Stt</th>
                                <th>Tên danh mục</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($listCategory as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>
                                        <a href="{{ route('category.edit', $item->id) }}"><button
                                                class="btn btn-warning me-3">Sửa</button></a>
                                        <form action="{{ route('category.destroy', $item->id) }}" method="POST"
                                            class="d-inline" onsubmit="return confirm('Bạn có đồng ý xóa không?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger">Xóa</button>
                                        </form>
                                        {{-- <button class="btn btn-danger"
                                            onclick="confirmDelete({{ $item->id }})">Xoá</button> --}}
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
    {{-- <script>
        // Hàm để gọi SweetAlert2 và xử lý khi xoá danh mục
        function confirmDelete(categoryId) {
            Swal.fire({
                title: 'Chọn cách xử lý sản phẩm!',
                text: "Bạn muốn xử lý các sản phẩm trước khi xoá danh mục?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Giữ lại sản phẩm',
                cancelButtonText: 'Xoá tất cả sản phẩm'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Gửi yêu cầu với hành động '1' (Giữ sản phẩm)
                    window.location.href = '/category/' + categoryId + '/destroy?action=1&_method=DELETE';
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    // Gửi yêu cầu với hành động '2' (Xoá tất cả sản phẩm)
                    window.location.href = '/category/' + categoryId + '/destroy?action=2&_method=DELETE';
                }
            });
        }
    </script> --}}
@endpush
