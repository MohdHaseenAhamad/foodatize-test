<?php

namespace App\Http\Controllers\Api\Website;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller {
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index() {
//        $results = Cart::all();
//
//        return response()->json([
//            'status' => 200,
//            'message' => "cart data fetch Successfully",
//            'data' => $results,
//        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     */
    public function create() {

    }

    public function getAllCartUserData($id) {
        if ((new UsersController())->checkUserStatus($id)) {
            $results = DB::table('cart')
                ->join('product', 'cart.product_id', '=', 'product.id')
                ->select('cart.*', DB::raw("(cart.price*cart.quantity) as total_count"), 'product.name', 'product.pieces', 'product.image')
                ->where('cart.user_id', '=', $id)
                ->where('cart.status', '!=', 1)
                ->where('cart.quantity', '!=', 0)
                ->get();
            return response()->json([
                'status' => 200,
                'message' => "cart data fetch Successfully",
                'data' => $results,
                'total_cart_amount' => Cart::totalProductPriceCountByUser($id)
            ], 200);
        }else
        {
            return response()->json([
                'status' => 401,
                'message' => 'Unauthorized Customer.',
            ], 401);
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */

    /**
     * Write code on Method
     * @return response()
     */
    public function addToCart(Request $request, $user_id) {
        if ((new UsersController())->checkUserStatus($user_id)) {
            $product_id = $request->product_id;
            $mode = $request->mode;
            $product = Product::where('id',$product_id)->where('quantity','>',0)->get();
//            if(count($product) > 0)
//            {
                $obj = new Cart();
                $res = Cart::where('product_id', $product_id)->where('status', '!=', 1)->where('user_id', $user_id)->get()->toArray();
                if (!empty($res[0])) {
                    $quantity = intval($res[0]['quantity']);
                    if ($mode == 'add') {
                        $quantity++;
                    }
                    if ($mode == 'subtract') {
                        $quantity--;
                    }

                    $resp = Cart::where('product_id', $product_id)->where('user_id', $user_id)->update(['quantity' => $quantity]);
                    return response()->json([
                        'status' => 200,
                        'message' => 'update to cart successfully',
                        'item' => Cart::totalCountProductByUser($user_id),
                        'total_price' => Cart::totalProductPriceCountByUser($user_id),
                    ], 200);
                } else {
                    $obj->user_id = $user_id;
                    $obj->product_id = $product->id;
                    $obj->quantity = 1;
                    $obj->price = $product->price;
                    $obj->status = 0;
                    $obj->save();

                    return response()->json([
                        'status' => 200,
                        'message' => 'add to cart successfully',
                        'item' => Cart::totalCountProductByUser($user_id),
                        'total_price' => Cart::totalProductPriceCountByUser($user_id),
                    ], 200);
                }
//            }
//            else
//            {
//                return response()->json([
//                    'status' => 205,
//                    'message' => 'update to cart successfully',
//                    'item' => Cart::totalCountProductByUser($user_id),
//                    'total_price' => Cart::totalProductPriceCountByUser($user_id),
//                ], 205);
//            }

        } else {
            return response()->json([
                'status' => 401,
                'message' => 'Unauthorized Customer.',
            ], 401);

        }


    }

    /**
     * Write code on Method
     * @return response()
     */
    public function update(Request $request, $user_id) {
        if ($request->id && $request->quantity) {
            $quantity = $request->quantity;
            $resp = Cart::where('pro_id', $request->id)->update(['quantity' => $quantity]);
            if ($resp) {
                return response()->json([
                    'status' => 200,
                    'message' => 'cart update successfully',
                    'item' => Cart::totalCountProductByUser($user_id),
                    'total_price' => Cart::totalProductPriceCountByUser($user_id),
                ], 200);
            } else {
                return response()->json([
                    'status' => 400,
                    'message' => 'something went wrong',
                ], 400);
            }

        }
    }

    /**
     * Write code on Method
     * @return response()
     */
    public function remove($id) {
        if ($id) {
            $cartRemove = Cart::findOrFail($id)->delete();
            if ($cartRemove) {
                return response()->json([
                    'status' => 200,
                    'message' => 'cart item remove successfully',
                    'data' => session()->get('cart')
                ], 200);
            } else {
                return response()->json([
                    'status' => 400,
                    'message' => 'something went wrong',
                ], 400);
            }

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


    /**
     * Remove the specified resource from storage.
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
    }
}
