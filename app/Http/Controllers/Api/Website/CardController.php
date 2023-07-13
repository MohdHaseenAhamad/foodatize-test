<?php

namespace App\Http\Controllers\Api\Website;

use App\Http\Controllers\Controller;
use App\Models\Card;
use App\Models\Product;
use Illuminate\Http\Request;

class CardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $results = Card::all();
        return response()->json([
            'status' => 200,
            'message' => "card data fetch Successfully",
            'data' => $results,
        ], 200);
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




    /**
     * Write code on Method
     *
     * @return response()
     */
    public function addToCart($id)
    {
        $product = Product::findOrFail($id);
        $obj = new Card();
        $res=Card::where('pro_id',$id)->get()->toArray();
        if(!empty($res[0])) {
            $quantity = intval($res[0]['quantity']);
            $quantity++;
            $resp=Card::where('pro_id',$id)->update(['quantity'=>$quantity]);
            return response()->json([
                'status' => 200,
                'message' => 'update to card successfully',
                'data'=>Card::all()
            ], 200);
        } else {
            $obj->user_id = 1;
            $obj->pro_id = $product->id;
            $obj->name = $product->name;
            $obj->quantity = 1;
            $obj->price = $product->price;
            $obj->image = $product->image;
            $obj->save();
            return response()->json([
                'status' => 200,
                'message' => 'add to card successfully',
                'data'=>Card::all()
            ], 200);
        }

    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function update(Request $request)
    {
        if($request->id && $request->quantity){
            $quantity = $request->quantity;
            $resp=Card::where('pro_id',$request->id)->update(['quantity'=>$quantity]);
            if($resp)
            {
                return response()->json([
                    'status' => 200,
                    'message' => 'card update successfully',
                    'data'=>Card::all()
                ], 200);
            }else
            {
                return response()->json([
                    'status' => 400,
                    'message' => 'something went wrong',
                ], 400);
            }

        }
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function remove(Request $request)
    {
        if($request->id) {
            $cardRemove = Card::findOrFail($request->id)->delete();
           if($cardRemove)
           {
               return response()->json([
                   'status' => 200,
                   'message' => 'card item remove successfully',
                   'data'=>session()->get('cart')
               ], 200);
           }else
           {
               return response()->json([
                   'status' => 400,
                   'message' => 'something went wrong',
               ], 400);
           }

        }
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
