@extends('layouts.app-theme')


@push('scripts')
@endpush

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Quản lý Admin</h5>
                </div>
                <div class="card-body">
                    <a href="{{ route('admin.create') }}"><button class="btn btn-secondary mb-2">Thêm mới</button></a>
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
                                <th>Tên tài khoản</th>
                                <th>Avatar</th>
                                <th>Quyền</th>
                                <th>Trang thái</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td> <img src="{{ $item->image }}" class="rounded-circle" alt="" width=100 height=100></td>
                                    <td>{{ $item->role == 1 ? 'user' : 'admin' }}</td>
                                    <td>
                                        {{ $item->status ? 'Hoạt động' : 'Dừng hoạt động' }}
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.show', $item->id) }}"><button
                                                class="btn btn-success me-3">Chi tiết</button></a>
                                        {{-- <a href="{{ route('admin.edit', $item->id) }}"><button
                                                class="btn btn-warning me-3">Sửa</button></a> --}}
                                        {{-- <form action="{{ route('user.destroy', $item->id) }}" method="POST"
                                            class="d-inline" onsubmit="return confirm('Bạn có đồng ý xóa không?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger">Xóa</button>
                                        </form> --}}
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
@endpush
