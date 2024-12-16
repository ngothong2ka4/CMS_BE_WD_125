@extends('layouts.app-theme')


@push('scripts')
@endpush

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
            <div class="card-header row">
                <h5 class="card-title mb-0 col-lg-9">Thùng rác</h5>
                <form class="col-lg-3">
                    <select name="table" onchange="this.form.submit()" class=" form-select">
                        <option value="all" {{!request('table') || request('table') == 'all' ?'selected' : '' }}> Tất cả</option>
                        <option value="product" {{request('table') == 'product' ?'selected' : '' }}>Sản phẩm</option>
                        <option value="category" {{request('table') == 'category' ?'selected' : '' }}>Danh mục</option>
                        <option value="voucher" {{request('table') == 'voucher' ?'selected' : '' }}>Ưu đãi</option>
                        <option value="combo" {{request('table') == 'combo' ?'selected' : '' }}>Bộ trang sức</option>
                        <option value="color" {{request('table') == 'color' ?'selected' : '' }}>Màu sắc</option>
                        <option value="size" {{request('table') == 'size' ?'selected' : '' }}>Kích thước</option>
                        <option value="material" {{request('table') == 'material' ?'selected' : '' }}>Chất liệu</option>
                        <option value="stone" {{request('table') == 'stone' ?'selected' : '' }}>Loại đá</option>
                    </select>
                </form>

            </div>
                <form action="" method="post" class="card-body">
                    @csrf
                    <table id="example" class="table table-bordered dt-responsive nowrap table-striped align-middle"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th width="20px"></th>
                                <th>Tiêu đề</th>
                                <th>Bảng</th>
                                <th>Thời gian xóa</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                     <tbody>
                            @foreach ($vouchers as $index => $item)
                                <tr>
                                    <td><input class="checkbox" type="checkbox" name="voucher[]" value="{{$item->id}}"></td>
                                    <td>{{ $item->code }}</td>
                                    <td>Ưu đãi</td>
                                    <td>{{$item->deleted_at}}</td>
                                    <td>
                                        <a class="btn btn-danger me-3" onclick="return confirm('Bạn có đồng ý xóa vĩnh viễn không?')" href="/binforce/{{ $item->id}}/voucher">
                                                Xóa</a>
                                        <a class="btn btn-warning me-3" onclick="return confirm('Bạn có đồng ý khôi phục không?')" href="/binrestore/{{ $item->id}}/voucher">
                                                Khôi phục</a>
                                    </td>
                                </tr>
                            @endforeach
                            @foreach ($products as $index => $item)
                                <tr>
                                    <td><input class="checkbox" type="checkbox" name="product[]" value="{{$item->id}}"></td>
                                    <td>{{ $item->name }}</td>
                                    <td>Sản phẩm</td>
                                    <td>{{$item->deleted_at}}</td>
                                    <td>
                                        <a class="btn btn-danger me-3" onclick="return confirm('Bạn có đồng ý xóa vĩnh viễn không?')" href="/binforce/{{ $item->id}}/product">
                                                Xóa</a>
                                        <a class="btn btn-warning me-3" onclick="return confirm('Bạn có đồng ý khôi phục không?')" href="/binrestore/{{ $item->id}}/product">
                                                Khôi phục</a>
                                    </td>
                                </tr>
                            @endforeach
                            @foreach ($categories as $index => $item)
                                <tr>
                                    <td><input class="checkbox" type="checkbox" name="category[]" value="{{$item->id}}"></td>
                                    <td>{{ $item->name }}</td>
                                    <td>Danh mục</td>
                                    <td>{{$item->deleted_at}}</td>
                                    <td>
                                        <a class="btn btn-danger me-3" onclick="return confirm('Bạn có đồng ý xóa vĩnh viễn không?')" href="/binforce/{{ $item->id}}/category">
                                                Xóa</a>
                                        <a class="btn btn-warning me-3" onclick="return confirm('Bạn có đồng ý khôi phục không?')" href="/binrestore/{{ $item->id}}/category">
                                                Khôi phục</a>
                                    </td>
                                </tr>
                            @endforeach
                            @foreach ($combos as $index => $item)
                                <tr>
                                    <td><input class="checkbox" type="checkbox" name="combo[]" value="{{$item->id}}"></td>
                                    <td>{{ $item->name }}</td>
                                    <td>Bộ trang sức</td>
                                    <td>{{$item->deleted_at}}</td>
                                    <td>
                                        <a class="btn btn-danger me-3" onclick="return confirm('Bạn có đồng ý xóa vĩnh viễn không?')" href="/binforce/{{ $item->id}}/combo">
                                                Xóa</a>
                                        <a class="btn btn-warning me-3" onclick="return confirm('Bạn có đồng ý khôi phục không?')" href="/binrestore/{{ $item->id}}/combo">
                                                Khôi phục</a>
                                    </td>
                                </tr>
                            @endforeach
                            @foreach ($colors as $index => $item)
                                <tr>
                                    <td><input class="checkbox" type="checkbox" name="color[]" value="{{$item->id}}"></td>
                                    <td>{{ $item->name }}</td>
                                    <td>Màu sắc</td>
                                    <td>{{$item->deleted_at}}</td>
                                    <td>
                                        <a class="btn btn-danger me-3" onclick="return confirm('Bạn có đồng ý xóa vĩnh viễn không?')" href="/binforce/{{ $item->id}}/color">
                                                Xóa</a>
                                        <a class="btn btn-warning me-3" onclick="return confirm('Bạn có đồng ý khôi phục không?')" href="/binrestore/{{ $item->id}}/color">
                                                Khôi phục</a>
                                    </td>
                                </tr>
                            @endforeach
                            @foreach ($sizes as $index => $item)
                                <tr>
                                    <td><input class="checkbox" type="checkbox" name="size[]" value="{{$item->id}}"></td>
                                    <td>{{ $item->name }}</td>
                                    <td>Kích thước</td>
                                    <td>{{$item->deleted_at}}</td>
                                    <td>
                                        <a class="btn btn-danger me-3" onclick="return confirm('Bạn có đồng ý xóa vĩnh viễn không?')" href="/binforce/{{ $item->id}}/size">
                                                Xóa</a>
                                        <a class="btn btn-warning me-3" onclick="return confirm('Bạn có đồng ý khôi phục không?')" href="/binrestore/{{ $item->id}}/size">
                                                Khôi phục</a>
                                    </td>
                                </tr>
                            @endforeach
                            @foreach ($materials as $index => $item)
                                <tr>
                                    <td><input class="checkbox" type="checkbox" name="material[]" value="{{$item->id}}"></td>
                                    <td>{{ $item->name }}</td>
                                    <td>Chất liệu</td>
                                    <td>{{$item->deleted_at}}</td>
                                    <td>
                                        <a class="btn btn-danger me-3" onclick="return confirm('Bạn có đồng ý xóa vĩnh viễn không?')" href="/binforce/{{ $item->id}}/material">
                                                Xóa</a>
                                        <a class="btn btn-warning me-3" onclick="return confirm('Bạn có đồng ý khôi phục không?')" href="/binrestore/{{ $item->id}}/material">
                                                Khôi phục</a>
                                    </td>
                                </tr>
                            @endforeach
                            @foreach ($stones as $index => $item)
                                <tr>
                                    <td><input class="checkbox" type="checkbox" name="stone[]" value="{{$item->id}}"></td>
                                    <td>{{ $item->name }}</td>
                                    <td>Loại đá</td>
                                    <td>{{$item->deleted_at}}</td>
                                    <td>
                                        <a class="btn btn-danger me-3" onclick="return confirm('Bạn có đồng ý xóa vĩnh viễn không?')" href="/binforce/{{ $item->id}}/stone">
                                                Xóa</a>
                                        <a class="btn btn-warning me-3" onclick="return confirm('Bạn có đồng ý khôi phục không?')" href="/binrestore/{{ $item->id}}/stone">
                                                Khôi phục</a>
                                    </td>
                                </tr>
                            @endforeach
                           
                        </tbody>

                        <tr>
                               
                            <td colspan="2"><input type="checkbox" id="selecctall"/> Chọn tất cả</td>
                              
                          
                                <td colspan=""> <button onclick="return confirm('Bạn có đồng ý xóa vĩnh viễn các mục đã chọn không?')" class="btn btn-danger me-3" type="submit" name="sub" value="checked">Xóa bỏ</button>
                                </td>
                                <td colspan="2">
                                <button onclick="return confirm('Bạn có đồng ý khôi phục các mục đã chọn không?')" class="btn btn-success me-3" type="submit" name="sub" value="">Khôi phục</button></td>
                                
                         
                        </tr>
                    </table>
                
</form>
            </div>
        </div><!--end col-->
    </div>
@endsection

@push('scripts')
    <script>
        new DataTable("#example", {
            order: [
                [3, 'desc']
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

        $(document).ready(function(){

$("#selecctall").change(function(){
  $(".checkbox").prop('checked', $(this).prop("checked"));
  });

});
    </script>
@endpush
