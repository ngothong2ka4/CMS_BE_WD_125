<?php
namespace App\Common;

use App\Models\Order;

class Common {


public static function autoUpdateStatus() {
    $second_date = date('Y-m-d H:i:s');
    $orders = Order::where('status','Giao hàng thành công')
    ->where('status_payment','Đã thanh toán')->get();
    foreach($orders as $order){
        $first_date = $order->updated_at;
        
        $diff = abs(strtotime($second_date) - strtotime($first_date));

        $time = floor($diff/60);
        if($time>=2){       //sau 2 phút đổi trạng thái sang hoàn thành
            $order->update(['status'=>'Hoàn thành']);
        }
    }

}
}