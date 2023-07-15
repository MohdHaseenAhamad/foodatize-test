<?php

namespace App\Http\Controllers\Api\Website;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $obj = new Order();
        $obj->order_number = '#FDT'.strtoupper(uniqid());
        $obj->user_id = $request->user_id;
        $obj->status = 'pending';
        $obj->grand_total =$request->grand_total;
        $obj->item_count = $request->item_count;
        $obj->adb_id = $request->adb_id;
        $obj->payment_status =0;
        $obj->payment_method = null;
        if($obj->save())
        {
            $items = Cart::where('user_id',$request->user_id)->get();
            foreach ($items as $item)
            {
                $orderItem = new OrderItem();
                $orderItem->order_id = $obj->id;
                $orderItem->product_id = $item->pro_id;
                $orderItem->quantity = $item->quantity;
                $orderItem->price = ($item->price * $item->quantity);
                $orderItem->save();
            }
        }
        return response()->json([
            'status' => 200,
            'message' => 'add to card successfully',
            'data'=>Cart::all()
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
