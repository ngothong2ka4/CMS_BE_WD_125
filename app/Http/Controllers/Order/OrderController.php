<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::all();
        return view('order.index', compact('orders'));
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
        $user = Auth::user();
        $order = Order::findOrFail($id);
        $orderdetails = OrderDetail::where('id_oder', $id)->get();
        $orderhistories = OrderHistory::where('id_order', $id)->get();
        return view('order.show', compact('order','orderdetails','orderhistories','user'));
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
    public function update(Request $request, Order $order)
    {
        $user = Auth::user();
        try {
            DB::beginTransaction();
            $request->validate([
                'to_status' => 'required'
            ],[
                'to_status.required' => 'Vui lòng chọn trạng thái'
            ]);
            if($request->to_status == 'Đã hủy'){
                if($request->note == '' || $request->note == null){
                    toastr()->error('Phải có ghi chú hủy đơn' );
                 return redirect()->back();

                };
            }
            if($request->to_status == 'Đã giao hàng thành công'){

            }
            $data = ['status' => $request->to_status];
            if($request->to_status == 'Giao hàng thành công'){
              $data['status_payment']  = 'Đã thanh toán';
            };
            $data_his = [
                'id_order' => $order->id,
                'id_user' => $user->id,
                'from_status' => $order->status,
                'to_status' => $request->to_status,
                'note' => $request->note,
            ];
            $order->update($data);
            OrderHistory::create($data_his);
            DB::commit();
            toastr()->success('Thay đổi trạng thái đơn hàng thành công!');
            return redirect()->back();
        } catch (\Exception $e) {
        toastr()->error('Đã có lỗi xảy ra: ' . $e->getMessage());
        return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
