<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $results = Product::all();
        return response()->json([
            'status' => 200,
            'message' => "item add Successfully",
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
    public function store(Request $request)
    {
//        die;
        $validator = validator::make($request->all(), [
            'name' => ['required', 'min:2', 'max:100'],
            'image' => ['required','image','mimes:jpg,png,jpeg,gif,svg','max:2048'],
            'pieces' => ['required'],
            'price' => ['required'],
            'description' => ['required', 'min:2', 'max:500'],
        ], [
            'required' => ':attribute is required.',
            'min' => 'Please enter at least :min characters',
            'max' => 'Please enter less then :max characters',
        ]);  /*Add Users Validation*/
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => $validator->messages(),
            ], 400);
        } else {
            $imageName = time().'.'.$request->image->extension();

            // Public Folder
            $request->image->move(public_path('images'), $imageName);
            $pro = new Product();
            $pro->name = $request->name;
            $pro->image = $imageName;
            $pro->pieces = $request->pieces;
            $pro->price = $request->price;
            $pro->description = $request->description;
            $pro->save();
if($pro->save())
{
    return response()->json([
        'status' => 200,
        'message' => "item add Successfully",

    ], 200);
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
    public function filter(Request $request, Product $pro)
    {
        $pro = $pro->newQuery();

        // Search for a user based on their name.
        if ($request->has('name')) {
            $pro->where('name','like', '%' .$request->input('name'). '%')->orWhere('description','like','%' .$request->input('name'). '%');
        }
        return response()->json([
            'status' => 200,
            'message' => "get all item Successfully",
            'data' => $pro->get(),
        ], 200);
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
        $productName = array();
        $productNameForLessThenQuantity = array();
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
                    $productNameForLessThenQuantity[] = $productItem[0]['name'];
                    $updateCartIds[] = $item['id'];
                }
            }
            else if(intVal($productItem[0]['quantity']) == 0)
            {
                $res=Cart::where('user_id',$user_id)->where('product_id',$productItem[0]['id'])->update(['quantity'=>0]);
                if(!empty($res))
                {
                    $productUpdateQtyCounter++;
                    $productName[] = $productItem[0]['name'];
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
                $massage1 = $productName[0]." & ".($productUpdateQtyCounter-1)." other items price are out of stock";
            }
            else
            {
                // $massage1 = $productName[0]." item is out of stock";
            }

            if($productUpdateQtyCounterForLessThenQuantity > 1)
            {
                $massage2 = $productNameForLessThenQuantity[0]." & ".($productUpdateQtyCounterForLessThenQuantity-1)." other items price are out of stock";
            }
            else
            {
                // $massage2 = $productNameForLessThenQuantity[0]." item is out of stock";
            }
            $massage = [$massage1,$massage2];
            return response()->json([
                'response' => 1,
                'message' => $massage,
                'update_product_ids' => implode(',',$updateCartIds),
            ], 200);
        }else
        {
            return response()->json([
                'response' => 0,
                'message' => "fetch all item Successfully",
                'update_product_ids' => '',
            ], 200);
        }
    }
}
