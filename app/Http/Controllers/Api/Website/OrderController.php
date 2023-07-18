<?php

namespace App\Http\Controllers\Api\Website;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
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
        $address_id =$request->address_id;
        $cart_ids = Cart::getOnlyCartIds($request->user_id);
//        $total_items = Cart::totalCountProductByUser($user_id);
        $total_item_price = Cart::totalProductPriceCountByUser($user_id);
//dd($total_item_price);
        $gst_per = (intval($total_item_price) * 18 ) / 100;
//        dd($gst_per);
        $km=Address::getKmInUserAddress($user_id,$address_id);
        $km_price = $this->getPrice($km);
        $to_pay = $total_item_price + $gst_per +$km_price;


        $obj = new Order();
        $obj->order_number = '#FDT' . strtoupper(uniqid());
        $obj->user_id = $request->user_id;
        $obj->cart_ids = $cart_ids;
        $obj->address_id = $address_id;
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
                'km_price' => $km_price,
                'to_pay' => $to_pay,
                'order_id'=>$obj->id
            ];

            return response()->json([
                'status' => 200,
                'message' => 'checkout successfully.',
                'data' => $data
            ], 200);
        }

    }

    public function getPrice($km)
    {
//        $km  =$request->km;
        if($km <= 2)
        {
            return 0;
        }
        else
        {
            $value = (int)($km / 2);
            $value = $value * 5;
           return $value;
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

    public function productCheckerForPrice($user_id)
    {
        $cartItem=Cart::where('user_id',$user_id)->get()->toArray();
        $productUpdatePriceCounter = 0;
        $updateCartIds = array();
        $productName = array();
        foreach($cartItem as $item)
        {
            $productItem=Product::where('id',$item['product_id'])->get()->toArray();
            // dd($productItem);
            if(intVal($productItem[0]['price']) == intVal($item['price']))
            {

            }
            else
            {
                $res=Cart::where('user_id',$user_id)->where('product_id',$productItem[0]['id'])->update(['price'=>$productItem[0]['price']]);
                if(!empty($res))
                {
                    $productUpdatePriceCounter++;
                    $productName[] = $productItem[0]['name'];
                    $updateCartIds[] = $item['id'];
                }


            }
        }
        if($productUpdatePriceCounter > 0)
        {
            $massage = "";
            if($productUpdatePriceCounter > 1)
            {
                $massage = $productName[0]." & ".($productUpdatePriceCounter-1)." other item price has been updates";
            }
            else
            {
                $massage = $productName[0]." item price has been updates";
            }
            return response()->json([
                'response' => 1,
                'message' => $massage,
                'update_product_ids' => implode(',',$updateCartIds),
            ], 200);
        }
        else
        {
            return response()->json([
                'response' => 0,
                'message' => "fetch all item Successfully",
                'update_product_ids' => '',
            ], 200);
        }
    }
    public function productCheckerForQty($user_id)
    {
        $cartItem=Cart::where('user_id',$user_id)->get()->toArray();
        $productUpdateQtyCounter = 0;
        $updateCartIds = array();
        $productName = "";
        $productNameForLessThenQuantity = "";
        $productUpdateQtyCounterForLessThenQuantity = 0;
        foreach($cartItem as $item)
        {
            $productItem=Product::where('id',$item['product_id'])->get()->toArray();
            // dd($productItem);
            if(intVal($productItem[0]['quantity']) < intVal($item['quantity']) && intVal($productItem[0]['quantity']) !=0)
            {
                $res=Cart::where('user_id',$user_id)->where('product_id',$productItem[0]['id'])->update(['quantity'=>$productItem[0]['quantity']]);
                if(!empty($res))
                {
                    $productUpdateQtyCounterForLessThenQuantity++;
                    if($productUpdateQtyCounterForLessThenQuantity == 1)
                    {
                        $productNameForLessThenQuantity = $productItem[0]['name'];
                    }

                    $updateCartIds[] = $item['id'];
                }
            }
            else if(intVal($productItem[0]['quantity']) == 0)
            {
                $res=Cart::where('user_id',$user_id)->where('product_id',$productItem[0]['id'])->update(['quantity'=>0]);
                if(!empty($res))
                {
                    $productUpdateQtyCounter++;
                    if($productUpdateQtyCounter==1)
                    {
                        $productName = $productItem[0]['name'];
                    }

                    $updateCartIds[] = $item['id'];
                }
            }
            else
            {

            }
        }


        if($productUpdateQtyCounter > 0 || $productUpdateQtyCounterForLessThenQuantity > 0)
        {
            $massage1 = "";
            $massage2 = "";
            $massage = array();
            if($productUpdateQtyCounter > 1)
            {
                $massage1 = $productName." & ".($productUpdateQtyCounter-1)." other items price are out of stock";
            }
            else
            {
                 $massage1 = $productName." is not my stock";
            }

            if($productUpdateQtyCounterForLessThenQuantity > 1)
            {
                $massage2 = $productNameForLessThenQuantity." & ".($productUpdateQtyCounterForLessThenQuantity-1)." other items price are out of stock";
            }
            else
            {
                 $massage2 = $productNameForLessThenQuantity." item is out of stock";
            }
            $massage = array($massage1,$massage2);
            return response()->json([
                'status' => 400,
                'message' => $massage,
                'update_product_ids' => implode(',',$updateCartIds),
            ], 400);
        }else
        {
            return response()->json([
                'response' => 200,
                'message' => "fetch all item Successfully",
                'update_product_ids' => '',
            ], 200);
        }
    }
}
