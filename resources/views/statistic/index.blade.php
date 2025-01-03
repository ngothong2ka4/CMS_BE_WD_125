@extends('layouts.app-theme')


@push('scripts')
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {
            'packages': ['corechart']
        });
        google.charts.setOnLoadCallback(drawVisualization);

        function drawVisualization() {
            var data = google.visualization.arrayToDataTable([
                ['Ngày', 'Doanh thu', 'Lợi nhuận'],

                @foreach ($completeStatistic as $statistic)
                    ['{{ $statistic['time'] }}', {{ $statistic['total_revenue'] }}, {{ $statistic['profit'] }}],
                @endforeach
            ]);

            var options = {
                title: '{{ $title }}',
                colors: ['#2d65cd', '#0ab39c'],
                titleTextStyle: {
                    fontSize: 18, // Kích thước chữ tiêu đề
                    bold: true
                },
                chartArea: {
                    top: 60, // Điều chỉnh margin trên của biểu đồ (tạo khoảng trống cho tiêu đề)
                    height: '70%', // Giảm chiều cao của vùng biểu đồ để tạo thêm khoảng cách phía dưới
                    width: '75%'
                },
                vAxis: {
                    title: 'Việt Nam Đồng'
                },
                hAxis: {
                    title: '{{ $cotY }}'
                },
                seriesType: 'bars',
                // series: {
                //     1: {
                //         type: 'line'
                //     }
                // }
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
                    <h2 class="h4">I. DANH SÁCH CẦN LÀM</h2>
                </div>
            </div>
        </div><!--end col-->
        <div class="row">
            <div class="col-2">
                <!-- card -->
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-uppercase fw-medium text-secondary text-truncate mb-0"> Chờ xác nhận</p>
                            </div>
                        </div>
                        <div>
                            <h6 class="fs-18 fw-semibold ff-secondary mt-2">{{ $orderStatus['choXacNhan'] }} ĐƠN</h6>
                        </div>
                        <div class="d-flex align-items-end justify-content-between mt-2">
                            <div>
                                <a href="{{ route('order.index', ['status' => 1]) }}" class="text-decoration-underline">Xem
                                    chi tiết</a>
                            </div>
                            <div>
                                <span class="mr-2 avatar-title bg-info-subtle rounded fs-3">
                                    <i class="bx bx-detail text-secondary"></i>
                                </span>
                            </div>
                        </div>
                    </div><!-- end card body -->
                </div><!-- end card -->
            </div><!-- end col -->

            <div class="col-2">
                <!-- card -->
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-uppercase fw-medium text-success text-truncate mb-0"> Đã xác nhận</p>
                            </div>
                        </div>
                        <div>
                            <h6 class="fs-18 fw-semibold ff-secondary mt-2">{{ $orderStatus['daXacNhan'] }} ĐƠN</h6>
                        </div>
                        <div class="d-flex align-items-end justify-content-between mt-2">
                            <div>
                                <a href="{{ route('order.index', ['status' => 2]) }}" class="text-decoration-underline">Xem
                                    chi tiết</a>
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

            <div class="col-2">
                <!-- card -->
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-uppercase fw-medium text-success text-truncate mb-0"> Đang giao</p>
                            </div>
                        </div>
                        <div>
                            <h6 class="fs-18 fw-semibold ff-secondary mt-2">{{ $orderStatus['dangGiao'] }} ĐƠN</h6>
                        </div>
                        <div class="d-flex align-items-end justify-content-between mt-2">
                            <div>
                                <a href="{{ route('order.index', ['status' => 3]) }}" class="text-decoration-underline">Xem
                                    chi tiết</a>
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

            <div class="col-2">
                <!-- card -->
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-uppercase fw-medium text-success text-truncate mb-0"> Thành công</p>
                            </div>
                        </div>
                        <div>
                            <h6 class="fs-18 fw-semibold ff-secondary mt-2">{{ $orderStatus['thanhCong'] }} ĐƠN</h6>
                        </div>
                        <div class="d-flex align-items-end justify-content-between mt-2">
                            <div>
                                <a href="{{ route('order.index', ['status' => '4&6']) }}"
                                    class="text-decoration-underline">Xem chi tiết</a>
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

            <div class="col-2">
                <!-- card -->
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-uppercase fw-medium text-warning text-truncate mb-0"> Giao thất bại</p>
                            </div>
                        </div>
                        <div>
                            <h6 class="fs-18 fw-semibold ff-secondary mt-2">{{ $orderStatus['giaoThatBai'] }} ĐƠN</h6>
                        </div>
                        <div class="d-flex align-items-end justify-content-between mt-2">
                            <div>
                                <a href="{{ route('order.index', ['status' => 5]) }}" class="text-decoration-underline">Xem
                                    chi tiết</a>
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

            <div class="col-2">
                <!-- card -->
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-uppercase fw-medium text-danger text-truncate mb-0"> Đã huỷ</p>
                            </div>
                        </div>
                        <div>
                            <h6 class="fs-18 fw-semibold ff-secondary mt-2">{{ $orderStatus['daHuy'] }} ĐƠN</h6>
                        </div>
                        <div class="d-flex align-items-end justify-content-between mt-2">
                            <div>
                                <a href="{{ route('order.index', ['status' => 7]) }}" class="text-decoration-underline">Xem
                                    chi tiết</a>
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
    </div>


    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h2 class="h4">II. THỐNG KÊ DOANH THU/LỢI NHUẬN</h2>
                </div>
                <div class="card-body">
                    <div class="row gx-0">
                        <div></div>
                        <div class="col-6">
                            <form action="{{ route('statistic.index') }}" method="get">
                                @csrf
                                {{-- <div class="row gx-2">
                                    <div class="col">
                                        <label for="year" class="form-label">Năm</label>
                                        <input type="number" class="form-control" name="year" placeholder="Nhập năm"
                                            required>
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
                                        <input type="number" class="form-control" name="day"
                                            placeholder="Nhập ngày">
                                    </div>
                                    <div class="col d-flex align-item-center">
                                        <button type="submit" style="height: 50%; margin-top: 29px"
                                            class="btn btn-sm btn-success">Gửi</button>
                                    </div>
                                </div> --}}

                                <div class="d-flex row gx-2">
                                    <div class="col-4">
                                        <label class="form-label">Loại thời gian</label>
                                        <select class="form-select" name="timeType" onchange="updateInputType(this)">
                                            <option selected value="">-Lựa chọn-</option>
                                            <option value="year">Năm</option>
                                            <option value="month">Tháng</option>
                                            <option value="day">Ngày</option>
                                            <option value="khoang">Khoảng</option>
                                        </select>
                                    </div>
                                    <div class="col-6" id="thoiDiem" style="display: none">
                                        <label for="year" class="form-label">Thời điểm</label>
                                        <input type="month" id="timeInput" class="form-control" name="time"
                                            required>
                                    </div>
                                    <div class="col-1" id="thoiDiem2" style="display: none">
                                        <div class="col d-flex align-item-center">
                                            <button type="submit" style="height: 50%; margin-top: 29px"
                                                class="btn btn-sm btn-secondary">Gửi</button>
                                        </div>
                                    </div>

                                </div>
                            </form>
                        </div>
                        <div class="col-6" id="khoangTime" style="display: none">
                            <form action="{{ route('statistic.index') }}" method="get">
                                @csrf
                                <div class="row gx-2">
                                    <div class="col">
                                        <label for="year" class="form-label">Bắt đầu</label>
                                        <input type="date" class="form-control" name="start" id="start"
                                            required>
                                    </div>
                                    <div class="col">
                                        <label for="year" class="form-label">Kết thúc</label>
                                        <input type="date" class="form-control" name="end" id="end"
                                            required>
                                    </div>
                                    <div class="col d-flex align-item-center">
                                        <button type="submit" style="height: 50%; margin-top: 29px"
                                            class="btn btn-sm btn-secondary">Gửi</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    {{-- <div id="chart_div" style="width: 900px; height: 500px;"></div> --}}
                    {{-- @if ($message)
                        <div class="alert alert-warning">{{ $message }}</div>
                    @endif --}}

                    @if (!$Statistic->isEmpty())
                        <div class="row mt-3">
                            <div class="col-3">
                                <!-- card -->
                                <div class="card card-animate" style="background-color: rgb(239, 249, 248)">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p class="text-uppercase fw-medium text-secondary text-truncate mb-0">Giá vốn</p>
                                            </div>
                                        </div>
                                        <div>
                                            <h6 class="fs-18 fw-semibold ff-secondary mt-2">
                                                {{ number_format($totalStatistic->total_cost, 0, ',', '.') }} VNĐ</h6>
                                        </div>
                                    </div><!-- end card body -->
                                </div><!-- end card -->
                            </div><!-- end col -->

                            <div class="col-3">
                                <!-- card -->
                                <div class="card card-animate" style="background-color: rgb(239, 249, 248)">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p style="display: inline"
                                                    class="text-uppercase fw-medium text-success text-truncate mb-0"> Doanh
                                                    thu
                                                </p>
                                                @if ($percentageChange !== null)
                                                    <p style="display: inline"
                                                        class="ms-5 text-uppercase fw-medium text-secondary text-truncate mb-0">
                                                        {{ number_format($percentageChange, 2) . '%' . PHP_EOL }}</p>
                                                @endif
                                            </div>
                                        </div>
                                        <div>
                                            <h6 class="fs-18 fw-semibold ff-secondary mt-2">
                                                {{ number_format($totalStatistic->total_revenue, 0, ',', '.') }} VNĐ</h6>
                                        </div>
                                    </div><!-- end card body -->
                                </div><!-- end card -->
                            </div><!-- end col -->

                            <div class="col-3">
                                <!-- card -->
                                <div class="card card-animate" style="background-color: rgb(239, 249, 248)">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p class="text-uppercase fw-medium text-success text-truncate mb-0"> Lợi
                                                    nhuận</p>
                                            </div>
                                        </div>
                                        <div>
                                            <h6 class="fs-18 fw-semibold ff-secondary mt-2">
                                                {{ number_format($totalStatistic->profit, 0, ',', '.') }} VNĐ</h6>
                                        </div>
                                    </div><!-- end card body -->
                                </div><!-- end card -->
                            </div><!-- end col -->

                            <div class="col-3">
                                <!-- card -->
                                <div class="card card-animate" style="background-color: rgb(239, 249, 248)">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p class="text-uppercase fw-medium text-success text-truncate mb-0"> Tổng
                                                    số đơn</p>
                                            </div>
                                        </div>
                                        <div>
                                            <h6 class="fs-18 fw-semibold ff-secondary mt-2">
                                                {{ $totalStatistic->total_orders }} ĐƠN</h6>
                                        </div>
                                    </div><!-- end card body -->
                                </div><!-- end card -->
                            </div><!-- end col -->
                        </div>
                        <center>
                            <div id="chart_div" style="width: 970px; height: 450px;"></div>
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
                <div class="card-body bg-light">
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="card" style="border-top: 1px solid black; border-left: 1px solid black;">
                                <div class="card-header align-items-center d-flex">
                                    <h2 class="h5">TOP 5 SẢN PHẨM CÓ DOANH THU CAO NHẤT</h2>
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
                                                                            class="fs-14 my-1 fw-normal">{{ Str::limit($item->product_name, 22, '...') }}</a>
                                                                    </h5>
                                                                    <h5 class="fs-14 my-1 fw-normal">
                                                                        {{ number_format($item->selling_price, 0, ',', '.') }}
                                                                        VNĐ
                                                                    </h5>
                                                                </div>

                                                            </div>
                                                        </td>
                                                        <td>
                                                            <h5 class="fs-14 my-1 fw-normal">
                                                                {{ number_format($item->total_revenue, 0, ',', '.') }}
                                                                VNĐ</h5>
                                                            <span class="text-muted fs-12">Doanh thu</span>
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
                            <div class="card" style="border-top: 1px solid black; border-left: 1px solid black;">
                                <div class="card-header align-items-center d-flex">
                                    <h2 class="h5">TOP 5 SẢN PHẨM CÓ LỢI NHUẬN CAO NHẤT</h2>
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
                                                                            class="fs-14 my-1 fw-normal">{{ Str::limit($item->product_name, 22, '...') }}</a>
                                                                    </h5>
                                                                    <h5 class="fs-14 my-1 fw-normal">
                                                                        {{ number_format($item->selling_price, 0, ',', '.') }}
                                                                        VNĐ
                                                                    </h5>
                                                                </div>

                                                            </div>
                                                        </td>
                                                        <td>
                                                        <td>
                                                            <h5 class="fs-14 my-1 fw-normal">
                                                                {{ number_format($item->total_profit, 0, ',', '.') }} VNĐ
                                                            </h5>
                                                            <span class="text-muted fs-12">Lợi nhuận</span>
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
                    <hr>
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="card" style="border-top: 1px solid black; border-left: 1px solid black;">
                                <div class="card-header align-items-center d-flex">
                                    <h2 class="h5">TOP 5 SẢN PHẨM BÁN CHẠY NHẤT</h2>
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
                                                                    <img src="{{ $item->product_image }}" alt="Ảnh"
                                                                        class="img-fluid d-block" />
                                                                </div>
                                                                <div>
                                                                    <h5 class="fs-14 my-1">
                                                                        <a href="apps-ecommerce-product-details.html"
                                                                            class="fs-14 my-1 fw-normal">{{ Str::limit($item->product_name, 22, '...') }}</a>
                                                                    </h5>
                                                                    <h5 class="fs-14 my-1 fw-normal">
                                                                        {{ number_format($item->selling_price, 0, ',', '.') }}
                                                                        VNĐ
                                                                    </h5>
                                                                </div>

                                                            </div>
                                                        </td>
                                                        <td>
                                                            <h5 class="fs-14 my-1 fw-normal">{{ $item->total_quantity }}
                                                            </h5>
                                                            <span class="text-muted fs-12">Đã bán</span>
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
                            <div class="card" style="border-top: 1px solid black; border-left: 1px solid black;">
                                <div class="card-header align-items-center d-flex">
                                    <h2 class="h5">TOP 5 SẢN PHẨM ĐƯỢC YÊU THÍCH NHẤT</h2>
                                </div><!-- end card header -->

                                <div class="card-body">
                                    <div class="table-responsive table-card">
                                        <table class="table table-hover table-centered align-middle table-nowrap mb-0">
                                            <tbody>
                                                @foreach ($topFavourite as $item)
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="avatar-sm bg-light rounded p-1 me-2">
                                                                    <img src="{{ $item->thumbnail }}" alt="Ảnh"
                                                                        class="img-fluid d-block" />
                                                                </div>
                                                                <div>
                                                                    <h5 class="fs-14 my-1">
                                                                        <a href="apps-ecommerce-product-details.html"
                                                                            class="fs-14 my-1 fw-normal">{{ Str::limit($item->name, 22, '...') }}</a>
                                                                    </h5>
                                                                    <h5 class="fs-14 my-1 fw-normal">
                                                                        {{ number_format($item->variants->first()->selling_price, 0, ',', '.') }}
                                                                        VNĐ
                                                                    </h5>
                                                                </div>

                                                            </div>
                                                        </td>
                                                        <td>
                                                            <h5 class="fs-14 my-1 fw-normal">
                                                                {{ $item->favorites_count }}
                                                            </h5>
                                                            <span class="text-muted fs-12">Lượt thích</span>
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
            </div>
        </div><!--end col-->
    </div>
@endsection

@push('scripts')
    {{-- <script>
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
    </script> --}}
    <script>
        document.getElementById('start').addEventListener('input', function() {
            document.getElementById('end').value = '';
        });

        document.getElementById('end').addEventListener('input', function() {
            const startInput = document.getElementById('start');
            const endInput = document.getElementById('end');

            const startDate = new Date(startInput.value);
            const endDate = new Date(endInput.value);

            if (startInput.value) {
                if (!endInput.value) {
                    return;
                }
                if (endDate <= startDate) {
                    alert('Ngày kết thúc phải sau ngày bắt đầu.');
                    endInput.value = '';
                    return;
                }
                const timeDiff = endDate.getTime() - startDate.getTime();
                const diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));

                if (diffDays > 10) {
                    alert('Ngày kết thúc không được vượt quá 10 ngày kể từ ngày bắt đầu.');
                    endInput.value = '';
                }
            }
        });
        document.getElementById('start').addEventListener('change', function() {
            const startInput = document.getElementById('start');
            const endInput = document.getElementById('end');

            if (startInput.value) {
                const startDate = new Date(startInput.value);
                startDate.setDate(startDate.getDate() + 1);
                endInput.value = startDate.toISOString().split('T')[0];
            }
        });
    </script>

    <script>
        function updateInputType(select) {
            const timeInput = document.getElementById('timeInput');
            const khoangTime = document.getElementById('khoangTime');
            const thoiDiem = document.getElementById('thoiDiem');
            const thoiDiem2 = document.getElementById('thoiDiem2');

            if (select.value === 'khoang') {
                khoangTime.style.display = 'block';
                thoiDiem.style.display = 'none';
                thoiDiem2.style.display = 'none';
            } else {
                khoangTime.style.display = 'none';
            }
            if (select.value === 'year') {
                thoiDiem.style.display = 'block';
                thoiDiem2.style.display = 'block';
                timeInput.type = 'number';
                timeInput.min = 2020;
                timeInput.max = new Date().getFullYear();
                timeInput.placeholder = "Nhập năm";
            } else if (select.value === 'month') {
                thoiDiem.style.display = 'block';
                thoiDiem2.style.display = 'block';
                timeInput.type = 'month';
                timeInput.removeAttribute('min');
                timeInput.removeAttribute('max');
            } else if (select.value === 'day') {
                thoiDiem.style.display = 'block';
                thoiDiem2.style.display = 'block';
                timeInput.type = 'date';
                timeInput.removeAttribute('min');
                timeInput.removeAttribute('max');
            } else {
                thoiDiem.style.display = 'none';
                thoiDiem2.style.display = 'none';
            }
        }

        if (condition) {
            document.getElementById('myDiv').style.display = 'none'; // Ẩn div
        }
    </script>
@endpush
