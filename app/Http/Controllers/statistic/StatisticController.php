<?php

namespace App\Http\Controllers\statistic;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
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
        $orderStatus = $this->countOrderStatus();

        // $time = $request->input('year', now()->year);

        $timeType = $request->query('timeType');
        $time = $request->input('time', now()->format('Y-m-d'));
        $year = substr($time, 0, 4);
        $month = substr($time, 5, 2);
        $day = substr($time, 8, 2);

        if ((empty($request->input('timeType')) && empty($request->input('start'))) || ($timeType === 'month')) {
            $lastRevenue = Order::select(DB::raw('SUM(total_payment) as total_revenue'))
                ->whereYear('created_at', $year)
                ->whereMonth('created_at', $month - 1)
                ->whereNotIn('status', ['7', '5'])
                ->first();
            $totalStatistic = Order::with('orderDetail')
                ->selectRaw('
                    COUNT(id) as total_orders,
                    SUM(total_payment) as total_revenue,
                    SUM(
                        (SELECT SUM(od.import_price * od.quantity)
                        FROM order_detail od
                        WHERE od.id_order = order.id)
                    ) as total_cost
                ')
                ->whereYear('created_at', $year)
                ->whereMonth('created_at', $month)
                ->whereNotIn('status', ['7', '5'])
                ->first();
            if ($totalStatistic) {
                $totalStatistic->profit = $totalStatistic->total_revenue - $totalStatistic->total_cost;
            }
            $percentageChange = 0;
            if ($lastRevenue && $lastRevenue->total_revenue > 0) {
                $percentageChange = (($totalStatistic->total_revenue - $lastRevenue->total_revenue) / $lastRevenue->total_revenue) * 100;
            }

            $Statistic = Order::with('orderDetail')
                ->selectRaw('
                    DAY(created_at) as time,
                    SUM(total_payment) as total_revenue,
                    SUM(
                        (SELECT SUM(od.import_price * od.quantity)
                        FROM order_detail od
                        WHERE od.id_order = order.id)
                    ) as total_cost
                ')
                ->whereYear('created_at', $year)
                ->whereMonth('created_at', $month)
                ->whereNotIn('status', ['7', '5'])
                ->groupBy(DB::raw('DAY(created_at)'))
                ->orderBy('time')
                ->get()
                ->map(function ($order) {
                    $order->profit = $order->total_revenue - $order->total_cost; // Tính lợi nhuận
                    return $order;
                });
            // dd($Statistic);
            $completeStatistic = $this->generateCompleteStatistics($Statistic, 1, 31);
            // dd($completeStatistic);
            $title = "Thống kê doanh thu, lợi nhuận kinh doanh tháng $month, năm $year";
            $cotY = "Ngày";
        } elseif ($timeType === 'year') {
            $lastRevenue = Order::select(DB::raw('SUM(total_payment) as total_revenue'))
                ->whereYear('created_at', $year - 1)
                ->whereNotIn('status', ['7', '5'])
                ->first();
            $totalStatistic = Order::with('orderDetail')
                ->selectRaw('
                    COUNT(id) as total_orders,
                    SUM(total_payment) as total_revenue,
                    SUM(
                        (SELECT SUM(od.import_price * od.quantity)
                        FROM order_detail od
                        WHERE od.id_order = order.id)
                    ) as total_cost
                ')
                ->whereYear('created_at', $year)
                ->whereNotIn('status', ['7', '5'])
                ->first();
            if ($totalStatistic) {
                $totalStatistic->profit = $totalStatistic->total_revenue - $totalStatistic->total_cost;
            }
            $percentageChange = 0;
            if ($lastRevenue && $lastRevenue->total_revenue > 0) {
                $percentageChange = (($totalStatistic->total_revenue - $lastRevenue->total_revenue) / $lastRevenue->total_revenue) * 100;
            }

            $Statistic = Order::with('orderDetail')
                ->selectRaw('
                    MONTH(created_at) as time,
                    SUM(total_payment) as total_revenue,
                    SUM(
                        (SELECT SUM(od.import_price * od.quantity)
                        FROM order_detail od
                        WHERE od.id_order = order.id)
                    ) as total_cost
                ')
                ->whereYear('created_at', $year)
                ->whereNotIn('status', ['7', '5'])
                ->groupBy(DB::raw('MONTH(created_at)'))
                ->orderBy('time')
                ->get()
                ->map(function ($order) {
                    $order->profit = $order->total_revenue - $order->total_cost;
                    return $order;
                });

            // dd($Statistic);
            $completeStatistic = $this->generateCompleteStatistics($Statistic, 1, 12);
            // dd($completeStatistic);
            $title = "Thống kê doanh thu, lợi nhuận kinh doanh năm $year";
            $cotY = "Tháng";
        } elseif ($timeType === 'day') {
            $lastRevenue = Order::select(DB::raw('SUM(total_payment) as total_revenue'))
                ->whereYear('created_at', $year)
                ->whereMonth('created_at', $month)
                ->whereDay('created_at', $day - 1)
                ->whereNotIn('status', ['7', '5'])
                ->first();
            $totalStatistic = Order::with('orderDetail')
                ->selectRaw('
                    COUNT(id) as total_orders,
                    SUM(total_payment) as total_revenue,
                    SUM(
                        (SELECT SUM(od.import_price * od.quantity)
                        FROM order_detail od
                        WHERE od.id_order = order.id)
                    ) as total_cost
                ')
                ->whereYear('created_at', $year)
                ->whereMonth('created_at', $month)
                ->whereDay('created_at', $day)
                ->whereNotIn('status', ['7', '5'])
                ->first();
            if ($totalStatistic) {
                $totalStatistic->profit = $totalStatistic->total_revenue - $totalStatistic->total_cost;
            }
            $percentageChange = 0;
            if ($lastRevenue && $lastRevenue->total_revenue > 0) {
                $percentageChange = (($totalStatistic->total_revenue - $lastRevenue->total_revenue) / $lastRevenue->total_revenue) * 100;
            }

            $Statistic = Order::with('orderDetail')
                ->selectRaw('
                    HOUR(created_at) as time,
                    SUM(total_payment) as total_revenue,
                    SUM(
                        (SELECT SUM(od.import_price * od.quantity)
                        FROM order_detail od
                        WHERE od.id_order = order.id)
                    ) as total_cost
                ')
                ->whereYear('created_at', $year)
                ->whereMonth('created_at', $month)
                ->whereDay('created_at', $day)
                ->whereNotIn('status', ['7', '5'])
                ->groupBy(DB::raw('HOUR(created_at)'))
                ->orderBy('time')
                ->get()
                ->map(function ($order) {
                    $order->profit = $order->total_revenue - $order->total_cost; // Tính lợi nhuận
                    return $order;
                });

            // dd($Statistic);
            $completeStatistic = $this->generateCompleteStatistics($Statistic, 0, 23);
            // dd($completeStatistic);
            $title = "Thống kê doanh thu, lợi nhuận kinh doanh ngày $day tháng $month, năm $year";
            $cotY = "Giờ";
        } elseif ($request->start && $request->end) {
            $startDate = $request->input('start');
            $endDate = $request->input('end');

            $totalStatistic = Order::with('orderDetail')
                ->selectRaw('
                    COUNT(id) as total_orders,
                    SUM(total_payment) as total_revenue,
                    SUM(
                        (SELECT SUM(od.import_price * od.quantity)
                        FROM order_detail od
                        WHERE od.id_order = order.id)
                    ) as total_cost
                ')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->whereNotIn('status', ['7', '5'])
                ->first();
            if ($totalStatistic) {
                $totalStatistic->profit = $totalStatistic->total_revenue - $totalStatistic->total_cost;
            }
            $percentageChange = null;

            $Statistic = Order::with('orderDetail')
                ->selectRaw('
                    DATE(created_at) as time,
                    SUM(total_payment) as total_revenue,
                    SUM(
                        (SELECT SUM(od.import_price * od.quantity)
                        FROM order_detail od
                        WHERE od.id_order = order.id)
                    ) as total_cost
                ')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->whereNotIn('status', ['7', '5'])
                ->groupBy(DB::raw('DATE(created_at)'))
                ->orderBy('time')
                ->get()
                ->map(function ($order) {
                    $order->profit = $order->total_revenue - $order->total_cost; // Tính lợi nhuận
                    return $order;
                });
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
            // dd($completeStatistic);
            $title = "Thống kê doanh thu, lợi nhuận kinh doanh từ $startDate đến $endDate";
            $cotY = "Mốc thời gian";
        } else {
            return redirect('/statistic');
        }

        $topSellers = OrderDetail::select(
            'id_product',
            'product_image',
            'product_name',
            DB::raw('MIN(selling_price) as selling_price'),
            DB::raw('SUM(quantity) as total_quantity')
        )->join('order', 'order_detail.id_order', '=', 'order.id')
            ->whereNotIn('order.status', ['7', '5'])
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
            DB::raw('SUM(
                quantity * selling_price - 
                (quantity * selling_price / (
                    SELECT SUM(quantity * selling_price) 
                    FROM order_detail 
                    WHERE order_detail.id_order = order.id
                ) * COALESCE(order.discount_value, 0))
            ) as total_revenue')
        )
            ->join('order', 'order_detail.id_order', '=', 'order.id')
            ->whereNotIn('order.status', ['7', '5'])
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
            DB::raw('SUM(
                quantity * (selling_price - import_price) - 
                (quantity * selling_price / (
                    SELECT SUM(quantity * selling_price) 
                    FROM order_detail 
                    WHERE order_detail.id_order = order.id
                ) * COALESCE(order.discount_value, 0))
            ) as total_profit')
        )->join('order', 'order_detail.id_order', '=', 'order.id')
            ->whereNotIn('order.status', ['7', '5'])
            ->groupBy('id_product', 'product_name', 'product_image')
            ->orderBy('total_profit', 'desc')
            ->take(5)
            ->get();

        // dd($topProfit);

        $topFavourite = Product::withCount('favorites')
            ->orderBy('favorites_count', 'desc')
            ->take(5)
            ->get();
        // dd($topProducts);

        return view('statistic.index', compact('orderStatus', 'completeStatistic', 'Statistic', 'totalStatistic', 'time', 'title', 'cotY', 'topSellers', 'topRevenue', 'topProfit', 'topFavourite', 'percentageChange'));
    }

    private function countOrderStatus()
    {
        return [
            'choXacNhan' => Order::where('status', '1')->count(),
            'daXacNhan' => Order::where('status', '2')->count(),
            'dangGiao' => Order::where('status', '3')->count(),
            'giaoThanhCong' => Order::where('status', '4')->count(),
            'giaoThatBai' => Order::where('status', '5')->count(),
            'hoanThanh' => Order::where('status', '6')->count(),
            'daHuy' => Order::where('status', '7')->count(),
            'thanhCong' => Order::whereIn('status', ['4', '6'])->count()
        ];
    }

    private function generateCompleteStatistics($Statistic, $start, $end)
    {
        $completeStatistic = [];

        foreach (range($start, $end) as $time) {
            $revenueData = $Statistic->where('time', $time)->first();
            $total_revenue = $revenueData ? $revenueData->total_revenue : 0;
            $profit = $revenueData ? $revenueData->profit : 0;
            $total_cost = $revenueData ? $revenueData->total_cost : 0;

            $completeStatistic[] = [
                'time' => $time,
                'total_revenue' => $total_revenue,
                'profit' => $profit,
                'total_cost' => $total_cost,
            ];
        }

        return $completeStatistic;
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
