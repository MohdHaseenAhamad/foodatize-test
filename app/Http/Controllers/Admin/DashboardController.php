<?php
/**
 * Created by PhpStorm.
 * User: MG-CLIENT-14
 * Date: 7/31/2023
 * Time: 1:31 PM
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class DashboardController extends Controller {

    public function index()
    {
        $order= Order::all();
        $order_count = $order->count();
        $users = User::all();
        $users_count = $users->count();
        $products = Product::all();
        $products_count = $products->count();
        return view('admin/index',['order_count'=>$order_count,'users_count'=>$users_count,'products_count'=>$products_count]);
    }

}
