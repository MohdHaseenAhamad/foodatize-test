<?php

namespace App\Http\Controllers\Api\Website;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        if ((new UsersController())->checkUserStatus($request->user_id))
        {
            $user_id = $request->user_id;
            $address_id = $request->address_id;
            $cart_ids = Cart::getOnlyCartIds($request->user_id);
            $total_item_price = Cart::totalProductPriceCountByUser($user_id);

            $gst_per = (intval($total_item_price) * 18) / 100;
            $km = Address::getKmInUserAddress($address_id);
            $km_price = !empty($km) ? $this->getPrice($km) : null;
            $to_pay = $total_item_price + $gst_per + $km_price;


            $obj = new Order();
            $obj->order_number = '#FDT' . strtoupper(uniqid());
            $obj->user_id = $request->user_id;
            $obj->cart_ids = $cart_ids;
            $obj->address_id = $address_id;
            $obj->status = 'pending';
            $obj->order_time = date('Y-m-d H:i:s');
            $obj->gst = 18;
            $obj->total_item_price = intval($total_item_price);
            $obj->final_amount = intval($to_pay);
            $obj->transaction_number = null;
            $obj->payment_status = 0;
            $obj->payment_method = null;
            if ($obj->save()) {
                $data = [
                    'order_id' => $obj->id,
                    'item_total' => $total_item_price,
                    'gst' => 18,
                    'gst_price' => $gst_per,
                    'km_price' => $km_price,
                    'to_pay' => $to_pay,
                    'order_id' => $obj->id
                ];

                return response()->json([
                    'status' => 200,
                    'message' => 'checkout successfully.',
                    'data' => $data
                ], 200);
            }
        }
        else
        {
            return response()->json([
                'status' => 401,
                'message' => 'Unauthorized Customer.',
            ], 401);
        }

    }

    public function getPrice($km) {
        if ($km <= 2) {
            return 0;
        } else {
            $value = (int)($km / 2);
            $value = $value * 5;
            return $value;
        }
    }
    public function cancelOrder($orderId)
    {
        $data = [
            'status' => 'cancel',
        ];
        $response = Order::where('id', $orderId)->update($data);
        if($response)
        {
            return response()->json([
                'status' => 200,
                'message' => 'your order cancel successfully.',
            ], 200);
        }
        else
        {
            return response()->json([
                'status' => 400,
                'message' => 'Something went wrong.',
            ], 400);
        }
    }

    public function selectPaymentMethod(Request $request, $orderId)
    {
        $data = [
            'payment_method' => 101,
        ];
        $response = Order::where('id', $orderId)->update($data);
        $cart_ids = Order::where('id', $orderId)->select('cart_ids')->get()->toArray();
        if ($response) {

            foreach (explode(',', $cart_ids[0]['cart_ids']) as $cart_id)
            {
                Cart::where('id', $cart_id)->update(['status' => 1]);
                $product_info = Cart::where('id', $cart_id)->select('quantity','product_id')->get()->toArray();
                $product_info_quantity = Product::where('id',$product_info[0]['product_id'])
                    ->select('quantity')
                    ->get()->toArray();
                Product::where('id',$product_info[0]['product_id'])->update(['quantity'=>(intval($product_info_quantity[0]['quantity']) - intval($product_info[0]['quantity']))]);
            }
            return response()->json([
                'status' => 200,
                'message' => 'payment method select successfully.',
                'data' => Order::where('id', $orderId)->get()
            ], 200);
        } else {
            return response()->json([
                'status' => 400,
                'message' => 'payment method not select successfully.',
            ], 400);
        }
    }

    public function finallyCheckout(Request $request) {

    }

    public function getOrderHistory($user_id)
    {
        if ((new UsersController())->checkUserStatus($user_id)) {
            $results = Order::where('user_id', $user_id)->orderBy('order_time', 'DESC')->get()->toArray();
            $data = array();
            foreach ($results as $key => $value) {
                $data[] = [
                    'id' => $value['id'],
                    'order_number' => $value['order_number'],
                    'item_count' => count(explode(',', $value['cart_ids'])),
                    'status' => $value['status'],
                    'address_id' => $value['address_id'],
                    'gst' => $value['gst'],
                    'payment_status' => $value['payment_status'],
                    'payment_method' => $value['payment_method'],
                    'created_at' => $value['created_at'],
                    'updated_at' => $value['updated_at'],
                    'order_time' => $value['order_time'],
                    'transaction_number' => $value['transaction_number'],
                    'final_amount' => $value['final_amount'],
                ];
            }

            if ($results) {
                return response()->json([
                    'status' => 200,
                    'message' => 'fetch order history successfully.',
                    'data' => $data
                ], 200);
            } else {
                return response()->json([
                    'status' => 400,
                    'message' => 'order history not successfully.',
                ], 400);
            }
        }else
        {
            return response()->json([
                'status' => 401,
                'message' => 'Unauthorized Customer.',
            ], 401);
        }
    }

    public function getOrderDetail($order_id) {
        $results = Order::where('id', $order_id)->get()->toArray();
//        $item = array();
        $cart_ids = explode(',', $results[0]['cart_ids']);
//        dd($cart_ids);
//        foreach (explode(',', $results[0]['cart_ids']) as $id)
//        {
            $item = DB::table('cart')
                ->leftJoin('product', 'cart.product_id', '=', 'product.id')
                ->select('cart.*','product.name','product.pieces','product.image')
                ->whereIn('cart.id',$cart_ids)
                ->get();
//        }
        $km = Address::getKmInUserAddress(intval($results[0]['address_id']));
//        $total_item_price = Cart::totalProductPriceCountByUser($results[0]['user_id']);
        $order_detail = [
            'booking_id'=>$results[0]['order_number'],
            'total_item_price'=>$results[0]['total_item_price'],
            'km'=>$km,
            'km_price'=>$this->getPrice($km),
            'gst'=>$results[0]['gst'],
            'to_pay'=>$results[0]['final_amount'],
            'payment_method'=>$results[0]['payment_method'],
            'payment_status'=>$results[0]['payment_status'],
        ];
        $data = [
            'item'=>$item,
            'order_detail'=>$order_detail
        ];
        if ($results) {
            return response()->json([
                'status' => 200,
                'message' => 'fetch order history successfully.',
                'item' => $item,
                'order_detail'=>$order_detail
            ], 200);
        } else {
            return response()->json([
                'status' => 400,
                'message' => 'order history not successfully.',
            ], 400);
        }

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

    public function productCheckerForPrice($user_id) {
        $cartItem = Cart::where('user_id', $user_id)->get()->toArray();
        $productUpdatePriceCounter = 0;
        $updateCartIds = array();
        $productName = array();
        foreach ($cartItem as $item) {
            $productItem = Product::where('id', $item['product_id'])->get()->toArray();
            // dd($productItem);
            if (intVal($productItem[0]['price']) == intVal($item['price'])) {

            } else {
                $res = Cart::where('user_id', $user_id)->where('product_id', $productItem[0]['id'])->update(['price' => $productItem[0]['price']]);
                if (!empty($res)) {
                    $productUpdatePriceCounter++;
                    $productName[] = $productItem[0]['name'];
                    $updateCartIds[] = $item['id'];
                }


            }
        }
        if ($productUpdatePriceCounter > 0) {
            $massage = "";
            if ($productUpdatePriceCounter > 1) {
                $massage = $productName[0] . " & " . ($productUpdatePriceCounter - 1) . " other item price has been updates";
            } else {
                $massage = $productName[0] . " item price has been updates";
            }
            return response()->json([
                'status' => 400,
                'message' => $massage,
                'update_product_ids' => implode(',', $updateCartIds),
            ], 400);
        } else {
            return response()->json([
                'status' => 200,
                'message' => "fetch all item Successfully",
                'update_product_ids' => '',
            ], 200);
        }
    }

    public function productCheckerForQty($user_id) {
        $cartItem = Cart::where('user_id', $user_id)->get()->toArray();
        $productUpdateQtyCounter = 0;
        $updateCartIds = array();
        $productName = "";
        $productNameForLessThenQuantity = "";
        $productUpdateQtyCounterForLessThenQuantity = 0;
        foreach ($cartItem as $item) {
            $productItem = Product::where('id', $item['product_id'])->get()->toArray();
            // dd($productItem);
            if (intVal($productItem[0]['quantity']) < intVal($item['quantity']) && intVal($productItem[0]['quantity']) != 0) {
                $res = Cart::where('user_id', $user_id)->where('product_id', $productItem[0]['id'])->update(['quantity' => $productItem[0]['quantity']]);
                if (!empty($res)) {
                    $productUpdateQtyCounterForLessThenQuantity++;
                    if ($productUpdateQtyCounterForLessThenQuantity == 1) {
                        $productNameForLessThenQuantity = $productItem[0]['name'];
                    }

                    $updateCartIds[] = $item['id'];
                }
            } else if (intVal($productItem[0]['quantity']) == 0) {
                $res = Cart::where('user_id', $user_id)->where('product_id', $productItem[0]['id'])->update(['quantity' => 0]);
                if (!empty($res)) {
                    $productUpdateQtyCounter++;
                    if ($productUpdateQtyCounter == 1) {
                        $productName = $productItem[0]['name'];
                    }

                    $updateCartIds[] = $item['id'];
                }
            } else {

            }
        }


        if ($productUpdateQtyCounter > 0 || $productUpdateQtyCounterForLessThenQuantity > 0) {
            $massage1 = "";
            $massage2 = "";
            $massage = array();
            if ($productUpdateQtyCounter > 1) {
                $massage1 = $productName . " & " . ($productUpdateQtyCounter - 1) . " other items price are out of stock";
            } else {
                $massage1 = $productName . " is not my stock";
            }

            if ($productUpdateQtyCounterForLessThenQuantity > 1) {
                $massage2 = $productNameForLessThenQuantity . " & " . ($productUpdateQtyCounterForLessThenQuantity - 1) . " other items price are out of stock";
            } else {
                $massage2 = $productNameForLessThenQuantity . " item is out of stock";
            }
            $massage = array($massage1, $massage2);
            return response()->json([
                'status' => 400,
                'message' => $massage,
                'update_product_ids' => implode(',', $updateCartIds),
            ], 400);
        } else {
            return response()->json([
                'status' => 200,
                'message' => "fetch all item Successfully",
                'update_product_ids' => '',
            ], 200);
        }
    }
}
