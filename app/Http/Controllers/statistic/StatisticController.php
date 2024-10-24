<?php

namespace App\Http\Controllers\statistic;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatisticController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $choXacNhan = Order::where('status', '1')->count();
        $daXacNhan = Order::where('status', '2')->count();
        $dangGiao = Order::where('status', '3')->count();
        $giaoThanhCong = Order::where('status', '4')->count();
        $giaoThatBai = Order::where('status', '5')->count();
        $daHuy = Order::where('status', '7')->count();

        $year = $request->input('year', now()->year);
        // $day = $request->input('day');

        // $yearlyRevenue = Order::select(
        //     DB::raw('MONTH(created_at) as month'),
        //     DB::raw('SUM(total_payment) as total_revenue')
        // )
        //     ->whereYear('created_at', $year)
        //     ->groupBy(DB::raw('MONTH(created_at)'))
        //     ->get();

        $Statistic = Order::with('orderDetail')
            ->select(
                DB::raw('MONTH(order.created_at) as time'),
                DB::raw('SUM(DISTINCT order.total_payment) as total_revenue'),
                DB::raw('SUM(order_details.import_price * order_details.quantity) as total_cost'),
                DB::raw('(SUM(DISTINCT order.total_payment) - SUM(order_details.import_price * order_details.quantity)) as profit')
            )
            ->join('order_detail as order_details', 'order.id', '=', 'order_details.id_order')
            ->whereYear('order.created_at', $year)
            ->where('order.status', '!=', 7)
            ->groupBy(DB::raw('MONTH(order.created_at)'))
            ->orderBy('time')
            ->get();
        // dd($Statistic);
        $completeStatistic = [];

        foreach (range(1, 12) as $month) {
            $revenueData = $Statistic->where('time', $month)->first();
            $total_revenue = $revenueData ? $revenueData->total_revenue : 0;
            $profit = $revenueData ? $revenueData->profit : 0;
            $total_cost = $revenueData ? $revenueData->total_cost : 0;

            $completeStatistic[] = [
                'time' => $month,
                'total_revenue' => $total_revenue,
                'profit' => $profit,
                'total_cost' => $total_cost,
            ];
        }
        $title = "Thống kê doanh thu, lợi nhuận kinh doanh năm $year";
        $cotY = "Tháng";

        if ($request->start && $request->end) {
            $startDate = $request->input('start');
            $endDate = $request->input('end');
            $Statistic = Order::with('orderDetail')
                ->select(
                    DB::raw('DATE(order.created_at) as time'),
                    DB::raw('SUM(DISTINCT order.total_payment) as total_revenue'),
                    DB::raw('SUM(order_detail.import_price * order_detail.quantity) as total_cost'),
                    DB::raw('(SUM(DISTINCT order.total_payment) - SUM(order_detail.import_price * order_detail.quantity)) as profit')
                )
                ->join('order_detail', 'order.id', '=', 'order_detail.id_order')
                ->whereBetween('order.created_at', [$startDate, $endDate])
                ->where('order.status', '!=', 7)
                ->groupBy(DB::raw('DATE(order.created_at)'))
                ->orderBy('time')
                ->get();
            // dd($Statistic);

            $start = new DateTime($startDate);
            $end = new DateTime($endDate);
            $end = $end->modify('+1 day');

            $dates = [];
            $interval = new DateInterval('P1D');
            $period = new DatePeriod($start, $interval, $end);
            foreach ($period as $date) {
                $dates[] = $date->format('Y-m-d');
            }
            // dd($dates);
            $completeStatistic = [];

            foreach ($dates as $date) {
                $revenueData = $Statistic->where('time', $date)->first();
                $total_revenue = $revenueData ? $revenueData->total_revenue : 0;
                $profit = $revenueData ? $revenueData->profit : 0;
                $total_cost = $revenueData ? $revenueData->total_cost : 0;

                $completeStatistic[] = [
                    'time' => $date,
                    'total_revenue' => $total_revenue,
                    'profit' => $profit,
                    'total_cost' => $total_cost,
                ];
            }
            $title = "Thống kê doanh thu, lợi nhuận kinh doanh từ $startDate đến $endDate";
            $cotY = "Mốc thời gian";
        }

        if ($Statistic->isEmpty()) {
            $message = "Không có dữ liệu cho năm $year.";
            $Statistic = collect();
        } else {
            $message = null;
            if ($request->month && $request->year) {
                $month = $request->input('month');
                $Statistic = Order::with('orderDetail')
                    ->select(
                        DB::raw('DAY(order.created_at) as time'),
                        DB::raw('SUM(DISTINCT order.total_payment) as total_revenue'),
                        DB::raw('SUM(order_details.import_price * order_details.quantity) as total_cost'),
                        DB::raw('(SUM(DISTINCT order.total_payment) - SUM(order_details.import_price * order_details.quantity)) as profit')
                    )
                    ->join('order_detail as order_details', 'order.id', '=', 'order_details.id_order')
                    ->whereYear('order.created_at', $year)
                    ->whereMonth('order.created_at', $month)
                    ->where('order.status', '!=', 7)
                    ->groupBy(DB::raw('DAY(order.created_at)'))
                    ->orderBy('time')
                    ->get();
                $completeStatistic = [];

                foreach (range(1, 31) as $day) {
                    $revenueData = $Statistic->where('time', $day)->first();
                    $total_revenue = $revenueData ? $revenueData->total_revenue : 0;
                    $profit = $revenueData ? $revenueData->profit : 0;
                    $total_cost = $revenueData ? $revenueData->total_cost : 0;

                    $completeStatistic[] = [
                        'time' => $day,
                        'total_revenue' => $total_revenue,
                        'profit' => $profit,
                        'total_cost' => $total_cost,
                    ];
                }
                $title = "Thống kê doanh thu, lợi nhuận kinh doanh tháng $month, năm $year";
                $cotY = "Ngày";
            }



            if ($request->year && $request->month && $request->day) {
                $day = $request->input('day');
                $Statistic = Order::with('orderDetail')
                    ->select(
                        DB::raw('HOUR(order.created_at) as time'),
                        DB::raw('SUM(DISTINCT order.total_payment) as total_revenue'),
                        DB::raw('SUM(order_details.import_price * order_details.quantity) as total_cost'),
                        DB::raw('(SUM(DISTINCT order.total_payment) - SUM(order_details.import_price * order_details.quantity)) as profit')
                    )
                    ->join('order_detail as order_details', 'order.id', '=', 'order_details.id_order')
                    ->whereYear('order.created_at', $year)
                    ->whereMonth('order.created_at', $month)
                    ->whereDay('order.created_at', $day)
                    ->where('order.status', '!=', 7)
                    ->groupBy(DB::raw('HOUR(order.created_at)'))
                    ->orderBy('time')
                    ->get();

                // dd($Statistic);
                $completeStatistic = [];

                foreach (range(0, 23) as $hour) {
                    $revenueData = $Statistic->where('time', $hour)->first();
                    $total_revenue = $revenueData ? $revenueData->total_revenue : 0;
                    $profit = $revenueData ? $revenueData->profit : 0;
                    $total_cost = $revenueData ? $revenueData->total_cost : 0;

                    $completeStatistic[] = [
                        'time' => $hour,
                        'total_revenue' => $total_revenue,
                        'profit' => $profit,
                        'total_cost' => $total_cost,
                    ];
                }
                $title = "Thống kê doanh thu, lợi nhuận kinh doanh ngày $day, tháng $month, năm $year";
                $cotY = "Khung giờ";
            }
        }

        $topSellers = OrderDetail::select(
            'id_product',
            'product_image',
            'product_name',
            DB::raw('MIN(selling_price) as selling_price'),
            DB::raw('SUM(quantity) as total_quantity')
        )->join('order', 'order_detail.id_order', '=', 'order.id')
            ->where('order.status', '!=', 7)
            ->groupBy('id_product', 'product_image', 'product_name')
            ->orderBy('total_quantity', 'desc')
            ->take(5)
            ->get();
        // dd($topSellers);

        $topRevenue = OrderDetail::select(
            'id_product',
            'product_name',
            'product_image',
            DB::raw('MIN(selling_price) as selling_price'),
            DB::raw('SUM(quantity * selling_price) as total_revenue')
        )->join('order', 'order_detail.id_order', '=', 'order.id')
            ->where('order.status', '!=', 7)
            ->groupBy('id_product', 'product_name', 'product_image')
            ->orderBy('total_revenue', 'desc')
            ->take(5)
            ->get();

        // dd($topRevenue);


        $topProfit = OrderDetail::select(
            'id_product',
            'product_name',
            'product_image',
            DB::raw('MIN(selling_price) as selling_price'),
            DB::raw('SUM(quantity * selling_price) - SUM(quantity * import_price) as total_profit')
        )->join('order', 'order_detail.id_order', '=', 'order.id')
            ->where('order.status', '!=', 7)
            ->groupBy('id_product', 'product_name', 'product_image')
            ->orderBy('total_profit', 'desc')
            ->take(5)
            ->get();

        // dd($topProfit);


        return view('statistic.index', compact('choXacNhan', 'daXacNhan', 'dangGiao', 'giaoThanhCong', 'giaoThatBai', 'daHuy', 'completeStatistic', 'Statistic', 'year', 'message', 'title', 'cotY', 'topSellers', 'topRevenue', 'topProfit'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
