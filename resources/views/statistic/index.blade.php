@extends('layouts.app-theme')


@push('scripts')
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {
            'packages': ['corechart']
        });
        google.charts.setOnLoadCallback(drawVisualization);

        function drawVisualization() {
            // Some raw data (not necessarily accurate)
            var data = google.visualization.arrayToDataTable([
                ['Ngày', 'Doanh thu', 'Lợi nhuận', 'Vốn đầu tư'],

                @foreach ($completeStatistic as $statistic)
                    [{{ $statistic['time'] }}, {{ $statistic['total_revenue'] }}, {{ $statistic['profit'] }},
                        {{ $statistic['total_cost'] }}
                    ],
                @endforeach
            ]);

            var options = {
                title: '{{ $title }}',
                titleTextStyle: {
                    fontSize: 18, // Kích thước chữ tiêu đề
                    bold: true
                },
                chartArea: {
                    top: 80, // Điều chỉnh margin trên của biểu đồ (tạo khoảng trống cho tiêu đề)
                    height: '70%',  // Giảm chiều cao của vùng biểu đồ để tạo thêm khoảng cách phía dưới
                    width: '70%'
                },
                vAxis: {
                    title: 'Việt Nam Đồng'
                },
                hAxis: {
                    title: '{{ $cotY }}'
                },
                seriesType: 'bars',
                series: {
                    1: {
                        type: 'line'
                    }
                }
            };

            var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
            chart.draw(data, options);
        }
    </script>
@endpush

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h2 class="h4">I. THỐNG KÊ ĐƠN HÀNG</h2>
                </div>
            </div>
        </div><!--end col-->
        <div class="col-xl-2 col-md-4">
            <!-- card -->
            <div class="card card-animate">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1 overflow-hidden">
                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0"> Chờ xác nhận</p>
                        </div>
                    </div>
                    <div>
                        <h6 class="fs-22 fw-semibold ff-secondary mt-2">{{ $choXacNhan }} ĐƠN</h6>
                    </div>
                    <div class="d-flex align-items-end justify-content-between mt-2">
                        <div>
                            <a href="{{ route('order.index') }}" class="text-decoration-underline">Xem chi tiết</a>
                        </div>
                        <div>
                            <span class="mr-2 avatar-title bg-info-subtle rounded fs-3">
                                <i class="bx bx-detail text-info"></i>
                            </span>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->

        <div class="col-xl-2 col-md-4">
            <!-- card -->
            <div class="card card-animate">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1 overflow-hidden">
                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0"> Đã xác nhận</p>
                        </div>
                    </div>
                    <div>
                        <h6 class="fs-22 fw-semibold ff-secondary mt-2">{{ $daXacNhan }} ĐƠN</h6>
                    </div>
                    <div class="d-flex align-items-end justify-content-between mt-2">
                        <div>
                            <a href="{{ route('order.index') }}" class="text-decoration-underline">Xem chi tiết</a>
                        </div>
                        <div>
                            <span class="mr-2 avatar-title bg-info-subtle rounded fs-3">
                                <i class="bx bx-detail text-success"></i>
                            </span>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->

        <div class="col-xl-2 col-md-4">
            <!-- card -->
            <div class="card card-animate">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1 overflow-hidden">
                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0"> Đang giao</p>
                        </div>
                    </div>
                    <div>
                        <h6 class="fs-22 fw-semibold ff-secondary mt-2">{{ $dangGiao }} ĐƠN</h6>
                    </div>
                    <div class="d-flex align-items-end justify-content-between mt-2">
                        <div>
                            <a href="{{ route('order.index') }}" class="text-decoration-underline">Xem chi tiết</a>
                        </div>
                        <div>
                            <span class="mr-2 avatar-title bg-info-subtle rounded fs-3">
                                <i class="bx bx-detail text-success"></i>
                            </span>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->

        <div class="col-xl-2 col-md-4">
            <!-- card -->
            <div class="card card-animate">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1 overflow-hidden">
                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0"> Giao thành công</p>
                        </div>
                    </div>
                    <div>
                        <h6 class="fs-22 fw-semibold ff-secondary mt-2">{{ $giaoThanhCong }} ĐƠN</h6>
                    </div>
                    <div class="d-flex align-items-end justify-content-between mt-2">
                        <div>
                            <a href="{{ route('order.index') }}" class="text-decoration-underline">Xem chi tiết</a>
                        </div>
                        <div>
                            <span class="mr-2 avatar-title bg-info-subtle rounded fs-3">
                                <i class="bx bx-detail text-success"></i>
                            </span>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->

        <div class="col-xl-2 col-md-4">
            <!-- card -->
            <div class="card card-animate">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1 overflow-hidden">
                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0"> Giao thất bại</p>
                        </div>
                    </div>
                    <div>
                        <h6 class="fs-22 fw-semibold ff-secondary mt-2">{{ $giaoThatBai }} ĐƠN</h6>
                    </div>
                    <div class="d-flex align-items-end justify-content-between mt-2">
                        <div>
                            <a href="{{ route('order.index') }}" class="text-decoration-underline">Xem chi tiết</a>
                        </div>
                        <div>
                            <span class="mr-2 avatar-title bg-info-subtle rounded fs-3">
                                <i class="bx bx-detail text-warning"></i>
                            </span>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->

        <div class="col-xl-2 col-md-4">
            <!-- card -->
            <div class="card card-animate">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1 overflow-hidden">
                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0"> Đã huỷ</p>
                        </div>
                    </div>
                    <div>
                        <h6 class="fs-22 fw-semibold ff-secondary mt-2">{{ $daHuy }} ĐƠN</h6>
                    </div>
                    <div class="d-flex align-items-end justify-content-between mt-2">
                        <div>
                            <a href="{{ route('order.index') }}" class="text-decoration-underline">Xem chi tiết</a>
                        </div>
                        <div>
                            <span class="mr-2 avatar-title bg-info-subtle rounded fs-3">
                                <i class="bx bx-detail text-danger"></i>
                            </span>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->
    </div>


    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h2 class="h4">II. THỐNG KÊ DOANH THU/LỢI NHUẬN</h2>
                </div>
                <div class="card-body">
                    <div class="row gx-0">
                        <div class="col-6">
                            <form action="{{ route('statistic.index') }}" method="get">
                                @csrf
                                <div class="row gx-2">
                                    <div class="col">
                                        <label for="year" class="form-label">Năm</label>
                                        <input type="number" class="form-control" name="year" placeholder="Nhập năm" required>
                                    </div>
                                    <div class="col">
                                        <label for="month" class="form-label">Tháng</label>
                                        <select class="form-select" name="month">
                                            <option selected value="">-Tháng-</option>
                                            @for ($i = 1; $i <= 12; $i++)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col">
                                        <label for="day" class="form-label">Ngày</label>
                                        <input type="number" class="form-control" name="day" placeholder="Nhập ngày">
                                    </div>
                                    <div class="col d-flex align-item-center">
                                        <button type="submit" style="height: 50%; margin-top: 29px" class="btn btn-sm btn-primary">Gửi</button>
                                    </div>
                                </div>                       
                            </form>
                        </div>
                        <div class="col-6 ms-6">
                            <form action="{{ route('statistic.index') }}" method="get">
                                @csrf
                                <div class="row gx-2">
                                    <div class="col">
                                        <label for="year" class="form-label">Bắt đầu</label>
                                        <input type="date" class="form-control" name="start" placeholder="Nhập năm" required>
                                    </div>
                                    <div class="col">
                                        <label for="year" class="form-label">Kết thúc</label>
                                        <input type="date" class="form-control" name="end" placeholder="Nhập năm" required>
                                    </div>
                                    <div class="col d-flex align-item-center">
                                        <button type="submit" style="height: 50%; margin-top: 29px" class="btn btn-sm btn-primary">Gửi</button>
                                    </div>
                                </div>                       
                            </form>
                        </div>
                    </div>
                    {{-- <div id="chart_div" style="width: 900px; height: 500px;"></div> --}}
                    @if ($message)
                        <div class="alert alert-warning">{{ $message }}</div>
                    @endif

                    @if (!$Statistic->isEmpty())
                    <center>
                        <div id="chart_div" style="width: 100%; height: 600px;"></div>
                    </center>
                        
                    @else
                        <div class="alert alert-warning" role="alert">
                            Khoảng thời gian bạn chọn không có đơn hàng nào, vui lòng chọn khoảng thời gian khác!
                        </div>
                    @endif

                </div>
            </div>
        </div><!--end col-->
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-header align-items-center d-flex">
                                    <h4 class="card-title mb-0 flex-grow-1">TOP 5 SẢN PHẨM BÁN CHẠY</h4>
                                </div><!-- end card header -->

                                <div class="card-body">
                                    <div class="table-responsive table-card">
                                        <table class="table table-hover table-centered align-middle table-nowrap mb-0">
                                            <tbody>
                                                @foreach ($topSellers as $item)
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="avatar-sm bg-light rounded p-1 me-2">
                                                                    <img src="{{ $item->product_image }}" alt=""
                                                                        class="img-fluid d-block" />
                                                                </div>
                                                                <div>
                                                                    <h5 class="fs-14 my-1">
                                                                        <a href="apps-ecommerce-product-details.html"
                                                                            class="text-reset">{{ Str::limit($item->product_name, 22, '...') }}</a>
                                                                    </h5>
                                                                </div>

                                                            </div>
                                                        </td>
                                                        <td>
                                                            <h5 class="fs-14 my-1 fw-normal">{{ $item->selling_price }}
                                                                VNĐ
                                                            </h5>
                                                            <span class="text-muted">Giá</span>
                                                        </td>
                                                        <td>
                                                            <h5 class="fs-14 my-1 fw-normal">{{ $item->total_quantity }}
                                                            </h5>
                                                            <span class="text-muted">Đã bán</span>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-header align-items-center d-flex">
                                    <h4 class="card-title mb-0 flex-grow-1">TOP 5 SẢN PHẨM DOANH THU CAO NHẤT</h4>
                                </div><!-- end card header -->

                                <div class="card-body">
                                    <div class="table-responsive table-card">
                                        <table class="table table-hover table-centered align-middle table-nowrap mb-0">
                                            <tbody>
                                                @foreach ($topRevenue as $item)
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="avatar-sm bg-light rounded p-1 me-2">
                                                                    <img src="{{ $item->product_image }}" alt=""
                                                                        class="img-fluid d-block" />
                                                                </div>
                                                                <div>
                                                                    <h5 class="fs-14 my-1">
                                                                        <a href="apps-ecommerce-product-details.html"
                                                                            class="text-reset">{{ Str::limit($item->product_name, 22, '...') }}</a>
                                                                    </h5>
                                                                </div>

                                                            </div>
                                                        </td>
                                                        <td>
                                                            <h5 class="fs-14 my-1 fw-normal">{{ $item->selling_price }}
                                                                VNĐ
                                                            </h5>
                                                            <span class="text-muted">Giá</span>
                                                        </td>
                                                        <td>
                                                            <h5 class="fs-14 my-1 fw-normal">{{ $item->total_revenue }}
                                                                VNĐ</h5>
                                                            <span class="text-muted">Doanh thu</span>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div> <!-- end row-->
                    <hr>
                    <div class="row">
                        <div class="card">
                            <div class="card-header align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1">TOP 5 SẢN PHẨM CÓ LỢI NHUẬN CAO NHẤT</h4>
                            </div><!-- end card header -->

                            <div class="card-body">
                                <div class="table-responsive table-card">
                                    <table class="table table-hover table-centered align-middle table-nowrap mb-0">
                                        <tbody>
                                            @foreach ($topProfit as $item)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="avatar-sm bg-light rounded p-1 me-2">
                                                                <img src="{{ $item->product_image }}" alt=""
                                                                    class="img-fluid d-block" />
                                                            </div>
                                                            <div>
                                                                <h5 class="fs-14 my-1">
                                                                    <a href="apps-ecommerce-product-details.html"
                                                                        class="text-reset">{{ Str::limit($item->product_name, 22, '...') }}</a>
                                                                </h5>
                                                            </div>

                                                        </div>
                                                    </td>
                                                    <td>
                                                        <h5 class="fs-14 my-1 fw-normal">{{ $item->selling_price }} VNĐ
                                                        </h5>
                                                        <span class="text-muted">Giá</span>
                                                    </td>
                                                    <td>
                                                        <h5 class="fs-14 my-1 fw-normal">{{ $item->total_profit }} VNĐ
                                                        </h5>
                                                        <span class="text-muted">Lợi nhuận</span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--end col-->
    </div>
@endsection

{{-- @push('scripts')
    <script>
        new DataTable("#example", {
            order: [
                [0, 'desc']
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
