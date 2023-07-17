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

}
