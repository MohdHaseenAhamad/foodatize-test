<?php
/**
 * Created by PhpStorm.
 * User: MG-CLIENT-14
 * Date: 7/27/2023
 * Time: 2:15 PM
 */

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Cart;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class OrderController extends Controller{
    public function index()
    {
       $results=DB::table('orders')
            ->leftJoin('users','orders.user_id','=','users.id')
            ->select('orders.*','users.name')
            ->get();
        return view('admin/order/listing',['total_order',count($results),'orders'=>$results]);
    }

    public function changeStatus(Request $request,$id)
    {
        $status = $request->status;

        $res=Order::where('id',intval($id))->update(['status'=>$status]);
        $results = Order::where('id',intval($id))->get()->toArray();
        $user_id = $results[0]['user_id'];
        $user_token = User::where('id',$user_id)->select('token')->get()->toArray();
        $token = $user_token[0]['token'];
        if($res)
        {
            $SERVER_API_KEY = 'AAAAHZjht3U:APA91bGvcwFwApKAHJ57AX9CnNKyvYREcZcdPnE700PiOxFT0WsFwzG1p44kv1UJCCmiJQXoaTnbrCYRrtOYVe5aj2v6lUl4ZjKYTDKJGcIwCbqNssJMSQrNeh8cQQKnCuBfsmS4Y9bf';
            $firebaseToken = User::whereNotNull('token')->pluck('token')->all();

            $data = [
                "to" => $token,
                "registration_ids" => $firebaseToken,
                "notification" => [
                    "massage" => 'Order Status update',
                ]
            ];
            $dataString = json_encode($data);

            $headers = [
                'Authorization: key=' . $SERVER_API_KEY,
                'Content-Type: application/json',
            ];

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

            $response = curl_exec($ch);
            echo $response;
        }else
        {
            echo false;
        }
    }
    public function detail($id)
    {
        $results = Order::where('id', $id)->get()->toArray();
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

//        dd($results[0]['user_id']);
        $km = Address::getKmInUserAddress(intval($results[0]['address_id']));
        $total_item_price = Cart::totalProductPriceCountByUser(intval($results[0]['user_id']));
        $user_info = User::find($results[0]['user_id']);
        $address_info = Address::find($results[0]['address_id']);
        $gst_per = (intval($results[0]['total_item_price']) * 18) / 100;
        $order_detail = [
            'booking_id'=>$results[0]['order_number'],
            'total_item_price'=>$results[0]['total_item_price'],
            'km'=>$km,
            'order_time'=>$results[0]['order_time'],
            'km_price'=>$this->getPrice($km),
            'gst'=>$results[0]['gst'],
            'gst_per'=>$gst_per,
            'to_pay'=>$results[0]['final_amount'],
            'payment_method'=>$results[0]['payment_method'],
            'payment_status'=>$results[0]['payment_status'],
        ];
        return view('admin/order/detail',['order_detail'=>$order_detail,'items'=>$item,'user_info'=>$user_info,'address'=>$address_info]);
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
}
