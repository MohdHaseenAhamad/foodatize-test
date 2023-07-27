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

class ProductController extends Controller
{
    public function index()
    {
        $results=Product::all();
        return view('admin/product/listing',['total_product'=>count($results),'products'=>$results]);
    }

    public function add()
    {
        return view('admin/product/add');
    }
}
