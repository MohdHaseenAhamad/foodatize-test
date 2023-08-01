<?php
/**
 * Created by PhpStorm.
 * User: MG-CLIENT-14
 * Date: 7/27/2023
 * Time: 1:34 PM
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

use JD\Cloudder\Facades\Cloudder;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller {
    public function index() {
        $results = Product::all();
        return view('admin/product/listing', ['total_product' => count($results), 'products' => $results]);
    }

    public function add() {
        return view('admin/product/add');
    }

    public function save(Request $request) {
        $validator = validator::make($request->all(), [
            'name' => ['required', 'min:2', 'max:100'],
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
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
            $width = 250;
            $height = 250;

            $image_name = $request->file('image')->getRealPath();
            Cloudder::upload($image_name, null, array(
                "folder" => "foodatize_products_images", "overwrite" => FALSE,
                "resource_type" => "image", "responsive" => TRUE, "transformation" => array("quality" => "70", "width" => "250", "height" => "250", "crop" => "scale")
            ));
            $image_url = Cloudder::show(Cloudder::getPublicId(), ["width" => $width, "height" => $height, "crop" => "scale", "quality" => 70, "secure" => "true"]);

            $pro = new Product();
            $pro->name = $request->name;
            $pro->image = $image_url;
            $pro->pieces = $request->pieces;
            $pro->quantity = $request->quantity;
            $pro->price = $request->price;
            $pro->description = $request->description;
            if ($pro->save()) {
                session()->flash('success', "Product add Successfully.");
                return redirect('admin/products/edit/'.$pro->id);
            }

        }
    }

    public function edit($id) {
        $result = Product::where('id', $id)->get();
        return view('admin/product/edit', ['result' => $result[0], 'mode' => 'edit','id'=>$id]);
    }

    public function update(Request $request, $id) {

        $validator = validator::make($request->all(), [
            'name' => ['required', 'min:2', 'max:100'],
            'pieces' => ['required'],
            'price' => ['required'],
            'description' => [ 'min:2', 'max:500'],
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
            $width = 250;
            $height = 250;
            $data  = [
                'name'=> $request->name,
                'pieces'=> $request->pieces,
                'price' => $request->price,
                'quantity'=> $request->quantity,
                'description' => $request->description,
            ];
            if($request->hasFile('image'))
            {
                $image_name = $request->file('image')->getRealPath();
                Cloudder::upload($image_name, null, array(
                    "folder" => "foodatize_products_images", "overwrite" => FALSE,
                    "resource_type" => "image", "responsive" => TRUE, "transformation" => array("quality" => "70", "width" => "250", "height" => "250", "crop" => "scale")
                ));
                $image_url = Cloudder::show(Cloudder::getPublicId(), ["width" => $width, "height" => $height, "crop" => "scale", "quality" => 70, "secure" => "true"]);

                $data['image'] = $image_url;
            }


            $retval = Product::where('id', $id)->update($data);

            if($retval)
            {
                session()->flash('success', "Product update Successfully.");
                return redirect('admin/products/edit/'.$id);
            }
        }
    }

    public function delete($id)
    {
        try {
            Product::find($id)->delete();
            session()->flash('success', "Product Deleted Successfully!!");
            return redirect('admin/products');

        } catch (\Exception $e) {
            session()->flash('error', "Something goes wrong!!");
            return redirect('admin/products');
        }
    }
}
