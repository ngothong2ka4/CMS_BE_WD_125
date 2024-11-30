<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use App\Models\Order;
use App\Models\Variant;

class UpdateOrderStatus extends Command
{
    protected $signature = 'order:update-status';
    protected $description = 'Cập nhật trạng thái đơn hàng nếu URL thanh toán hết hạn';

    public function handle()
    {
        $orders = Order::where('status', Order::STATUS_PENDING)
                        ->where('status_payment',Order::STATUS_PAYMENT_PENDING)
                        ->where('payment_role',Order::PAYMENT_ROLE_VN_PAY)
                        ->get();

        foreach ($orders as $order) {
            $cacheKey = $order->id . '_' . Order::URL_PAYMENT;

            if (!Cache::has($cacheKey)) {
                $order->update(['status' => Order::STATUS_CANCELED]);
                $this->info("Order ID {$order->id} đã được chuyển sang trạng thái cancelled.");
                
                foreach ($order->orderDetail as $orderDetail) {
                    $variant = Variant::find($orderDetail->id_variant);
                    if ($variant) {
                        $variant->quantity += $orderDetail->quantity;
                        $variant->save();
                    }
                }
            }
        }

        $this->info("Cập nhật trạng thái đơn hàng hoàn tất.");
    }
}
