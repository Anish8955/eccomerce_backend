<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(){
         $orders = Order::orderBy('created_at','DESC')->get();

         return response()->json([
             'data' => $orders,
             'status' => 200 
         ],200);

    }

    public function detail($id){
         $order = Order::with('items','items.product')->find($id);

         if($order == null) {
              return response()->json([
             'data' => [], 
             'message' => 'order not found',
             'status' => 200 
         ],200);
         }

         return response()->json([
             'data' => $order,
             'status' => 200 
         ],200);
         
    }

    public function updateOrder($id, Request $request){
        $order = Order::find($id);

        if($order == null){
             return response()->json([
             'message' =>"Order not found",
             'status' => 404 
         ],404);

        }

        $order->status = $request->status;
        $order->payment_status = $request->payment_status;
        $order->save();

        return response()->json([
             'data' => $order,
             'message' =>"Order updated successfully",
             'status' => 200
         ],200);
    }

   public function getTotalOrders()
{
    $totalOrders = Order::count(); // You can add conditions if needed

    return response()->json([
        'total_orders' => $totalOrders
    ]);
}

}
