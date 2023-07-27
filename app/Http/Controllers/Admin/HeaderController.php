<?php
/**
 * Created by PhpStorm.
 * User: MG-CLIENT-14
 * Date: 7/26/2023
 * Time: 4:33 PM
 */

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class HeaderController extends Controller {
    public function index()
    {
        $table_header = DB::table('header')->get();
//        dd($table_header);
        return view('admin/header',['table_header'=> $table_header]);
    }
}
