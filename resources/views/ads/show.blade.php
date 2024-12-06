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
                ['Ngày', 'Lượt truy cập',],

                @foreach ($visits as $visit)
                    ['{{ $visit['time'] }}',  {{ $visit['visit'] }}],
                @endforeach
            ]);

            var options = {
                title: 'Biểu đồ theo dõi lượt truy cập từ {{$start}} đến {{$end}}',
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
                    title: 'Lượt truy cập'
                },
                hAxis: {
                    title: 'Ngày'
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
        <div class="card mb-1">
            <div class="card-header" style="background: transparent !important;">
                <h2 class="mb-0">Chi tiết dịch vụ </h2>
            </div>
        </div>


        <div class="card mb-2">
            <div class="card-header ">
                <div class="row">
                    <h4 class="mb-0 col-lg-10">Thông tin dịch vụ</h4>
                    @if($ads->status ==1)
                    <div class="col-lg-2">
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            Dừng hoạt động
                        </button>


                    </div>

                    @endif
                </div>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <form action="{{ route('ads_service.destroy', $ads->id) }}" class="modal-content" method="POST">
                        @csrf
                        @method('DELETE')
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Nhập ghi chú</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <textarea class="form-control" name="note" id="meassageInput" rows="3"></textarea>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                            <button type="submit" class="btn btn-primary">Lưu</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6">
                        <label for="basiInput" class="form-label">Mã dịch vụ</label>
                        <input type="text" class="form-control mb-3" id="basiInput" name="name"
                            value="#{{ $ads->id }}" disabled>
                    </div>
                    <div class="col-lg-6">
                        <label for="basiInput" class="form-label">Lượt truy cập</label>
                        <input type="text" class="form-control mb-3" id="basiInput" name="name"
                            value="{{$ads->visits}}"
                            disabled>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <label for="basiInput" class="form-label">Trạng thái</label>
                        <input type="text" class="form-control mb-3" id="basiInput" name="name"
                            @if($ads-> status == 1)
                        value=" Hoạt động"
                        @endif
                        @if($ads-> status == 2)
                        value=" Dừng hoạt động"
                        @endif disabled>
                    </div>
                    <div class="col-lg-6">
                        <label for="basiInput" class="form-label">Vị trí</label>
                        <input type="text" class="form-control mb-3" id="basiInput" name="name"
                            value="{{ $ads->location }}" disabled>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <label for="basiInput" class="form-label">Phương thức thanh toán</label>
                        <input type="text" class="form-control mb-3" id="basiInput" name="name"
                            value="Thanh toán qua VNPay" disabled>


                    </div>

                    <div class="col-lg-6">
                        <label for="basiInput" class="form-label">Trạng thái thanh toán</label>
                        <input type="text" class="form-control mb-3" id="basiInput" name="name"
                            @if($ads-> status_payment == 1)
                        value = "Chưa thanh toán"
                        @endif
                        @if($ads->status_payment == 2)
                        value = "Đã thanh toán"
                        @endif disabled>

                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <label for="basiInput" class="form-label">Tên khách hàng</label>
                        <input type="text" class="form-control mb-3" id="basiInput" name="name"
                            value="{{ $ads->name }}" disabled>

                    </div>

                    <div class="col-lg-6">
                        <label for="basiInput" class="form-label">Điện thoại</label>
                        <input type="text" class="form-control mb-3" id="basiInput"
                            value="{{ $ads->phone }}" disabled>

                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <label for="basiInput" class="form-label">Thời gian bắt đầu</label>
                        <input type="text" class="form-control mb-3" id="basiInput" name="name"
                            value="{{ $ads->start }}" disabled>

                    </div>

                    <div class="col-lg-6">
                        <label for="basiInput" class="form-label">Thời gian kết thúc</label>
                        <input type="text" class="form-control mb-3" id="basiInput"
                            value="{{ $ads->end }}" disabled>

                    </div>
                </div>
                <div class="">
                        <label for="basiInput" class="form-label">Đơn giá</label>
                        <input type="text" class="form-control mb-3" id="basiInput"
                            value="{{ number_format($ads->price)}} đ" disabled>

                    </div>
            </div>
        </div>
        <div class="card mt-2">
            <div class="card-header">
                <h4 class="mb-0">Chi tiết quảng cáo</h4>
            </div>
            <div class="card-body">
                <table id="example"
                    class="table table-badsed dt-responsive nowrap table-striped align-middle"
                    style="width:100%">
                    <thead>
                        <tr>
                           
                            <th>Tiêu đề</th>
                            <th>Nội dung</th>
                            <th>Hình ảnh</th>
                            <th>Đường dẫn</th>
                            <th>Thời gian thay đổi</th>
                        </tr>
                    </thead>
                    <tbody>
                    
                        <tr>
                            <td>{{$config->title}}</td>
                            <td>{{$config->highlight}}</td>
                            <td><img src="{{$config->image}}" alt="" width="100px"></td>
                            <td>{{$config->url}}</td>
                            <td>{{$config->created_at}}</td>
                        </tr>

                       
                    </tbody>
                </table>


            </div>



        </div>
    
        <div class="card-header row">
                <h4 class="mb-0 col-6">Thống kê lượt truy cập</h4>
                <div class="col-6" id="khoangTime" >
                            <form method="get">
         
                                <div class="row">
                                    <div class="col">
                                        Từ 
                                        <input type="date" class="form-control" name="start" id="start" min="{{\Carbon\Carbon::parse($ads->start)->format('Y-m-d')}}"
                        max="{{\Carbon\Carbon::now()->format('Y-m-d')}}" value = {{$start}}
                                            required>
                                    </div>
                                    <div class="col">
                                        Đến
                                        <input type="date" class="form-control" name="end" id="end" min="{{\Carbon\Carbon::parse($ads->start)->format('Y-m-d')}}"
                        max="{{\Carbon\Carbon::now()->format('Y-m-d')}}" value = {{$end}}
                                            required>
                                    </div>
                                    <div class="col">
                                        <button type="submit"
                                            class="btn btn-sm btn-secondary form-control mt-4">Gửi</button>
                                    </div>
                                </div>
                            </form>
                        </div>
            </div>
            @if(count($visits) > 0)
        <div id="chart_div" style=" height: 450px;"></div>
        @else
        <div class="card-header row">
        <h4 class="mb-0 col-6" style=" color:red">Không có lượt truy cập</h4>
        </div>
        @endif
        <div class="card mt-2">


            <div class="mt-3 text-center mb-2">
                <a href="{{ route('ads_service.index') }}" class="btn btn-success">Quay lại</a>

            </div>

        </div>
    </div>

    @endsection