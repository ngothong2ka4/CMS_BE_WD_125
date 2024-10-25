<?php

namespace App\Common;

use App\Models\Order;
use App\Models\OrderHistory;
use Illuminate\Support\Facades\DB;

class Common
{


    public static function autoUpdateStatus()
    {
        $second_date = date('Y-m-d H:i:s');
        try {
            $orders = Order::where('status', 4)
                ->where('status_payment', 2)->get();
            foreach ($orders as $order) {
                $first_date = $order->updated_at;

                $diff = abs(strtotime($second_date) - strtotime($first_date));

                $time = floor($diff / 60);
                if ($time >= 2) {       //sau 2 phút đổi trạng thái sang hoàn thành
                    OrderHistory::create([
                        'id_order' => $order->id,
                        'id_user' => 0,
                        'from_status' => $order->status,
                        'to_status' => 6
                    ]);
                    $order->update(['status' => 6]);
                }
            }
        } catch (\Exception $e) {
            toastr()->error('Đã có lỗi xảy ra: ' . $e->getMessage());
        }
    }
}
