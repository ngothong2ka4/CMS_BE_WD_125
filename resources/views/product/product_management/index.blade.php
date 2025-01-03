@extends('layouts.app-theme')


@push('scripts')
     
@endpush

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header row">
                    <h5 class="card-title mb-0 col-lg-9">Quản lý sản phẩm</h5>
                    <form class="col-lg-3">
                    <select name="category" onchange="this.form.submit()" class=" form-select">
                        <option value="all" {{!request('category') || request('category') == 'all' ?'selected' : '' }}> Tất cả sản phẩm</option>
                        @foreach($categories as $category)
                        <option value="{{$category->id}}" {{request('category') == $category->id ?'selected' : '' }}>{{$category->name}}</option>
                        @endforeach
                        <option value="0" {{request('category') == '0' ?'selected' : '' }}> Sản phẩm chưa có danh mục</option>
                        
                    </select>
                </form>
                </div>
                <div class="card-body">
                    <a href="{{ route('product_management.create') }}"><button class="btn btn-secondary mb-2">Thêm mới</button></a>
                    <table id="example"
                        class="table table-bordered dt-responsive nowrap table-striped align-middle"
                        style="width:100%">
                        <thead>
                        <tr>
                            <th >Id</th>
                            <th >Tên sản phẩm</th>
                            <th >Hình ảnh</th>
                            <th >Danh mục</th>
                            <th >Chất liệu</th>
                            <th >Đá</th>
                            <th> Đã bán</th>
                            <th >Hành động</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $index => $product)
                                <tr>
                                    <td>{{ $product->id }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td><img src="{{ $product->thumbnail}}" alt="" width = 80></td>
                                    <td>{{ $product->category?->name }}</td>
                                    <td>{{ $product->material?->name }}</td>
                                    <td>{{ $product->stone?->name }}</td>
                                    <td>{{ $product->sold }}</td>

                                
                                    <td>                                        
                                        <a href="{{ route('product_management.show', $product->id) }}"><button class="btn btn-info">Chi tiết</button></a>
                                        <a href="{{ route('product_management.edit', $product->id) }}"><button class="btn btn-warning">Sửa</button></a>
                                        
                                            <form action="{{ route('product_management.destroy', $product->id) }}" method="POST" style="display:inline;">
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
