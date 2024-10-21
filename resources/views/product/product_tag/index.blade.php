@extends('layouts.app-theme')


@push('scripts')
@endpush

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card ">
                <div class="card-header">
                    <h5 class="card-title mb-0">Quản lý Thẻ</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            @include('product.product_tag.product_stone.index')
                        </div>
                        <div class="col-lg-6">
                            @include('product.product_tag.product_material.index')
                        </div>
                    </div>
                </div><!--end col-->
            </div>
        </div>
    </div>
@endsection
{{-- @push('scripts')
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
@endpush --}}
