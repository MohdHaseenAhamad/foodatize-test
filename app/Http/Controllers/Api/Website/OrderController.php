<?php

namespace App\Http\Controllers\Api\Website;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller {
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     */
    public function create() {

    }

    /**
     * Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $user_id = $request->user_id;
        $cart_ids = Cart::getOnlyCartIds($request->user_id);
//        $total_items = Cart::totalCountProductByUser($user_id);
        $total_item_price = Cart::totalProductPriceCountByUser($user_id);
        $gst_per = (100 / $total_item_price) * 18;
        $to_pay = $total_item_price + $gst_per;

        $obj = new Order();
        $obj->order_number = '#FDT' . strtoupper(uniqid());
        $obj->user_id = $request->user_id;
        $obj->cart_ids = $cart_ids;
        $obj->address_id = $request->address_id;
        $obj->status = 'pending';
        $obj->order_time = date('Y-m-d H:i:s');
        $obj->gst = 18;
        $obj->final_amount = $to_pay;
        $obj->transaction_number = null;
        $obj->payment_status = 0;
        $obj->payment_method = null;
        $obj->save();
        if ($obj->save()) {
            foreach (explode(',', $cart_ids) as $cart_id) {
                Cart::where('user_id', $user_id)->where('id', $cart_id)->update(['status' => 1]);
            }
            $data = [
                'item_total' => $total_item_price,
                'gst' => 18,
                'gst_price' => $gst_per,
                'to_pay' => $to_pay,
                'order_id'=>$obj->id
            ];

            return response()->json([
                'status' => 200,
                'message' => 'add to card successfully',
                'data' => $data
            ], 200);
        }

    }

    public function selectPaymentMethod(Request $request)
    {
//        $data = [
//            'payment_method'=>$request->payment_method,
//            'payment_method'=>$request->payment_method,
//        ];
    }

    /**
     * Display the specified resource.
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
    }
}
