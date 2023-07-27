<?php
/**
 * Created by PhpStorm.
 * User: MG-CLIENT-14
 * Date: 7/27/2023
 * Time: 2:15 PM
 */

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Order;
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

        if($res)
        {
            echo true;
        }else
        {
            echo false;
        }
    }
}
