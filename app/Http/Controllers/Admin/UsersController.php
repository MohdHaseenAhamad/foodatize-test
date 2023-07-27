<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index()
    {
        $results=User::all();
//        dd($results);
        return view('admin/users/users',['users_count'=>count($results),'users'=>$results]);
    }
    public function deleteUser($id) {

        try {
            User::find($id)->delete();
            session()->flash('success', "User Deleted Successfully!!");
            return redirect('admin/users');

        } catch (\Exception $e) {
            session()->flash('error', "Something goes wrong!!");
            return redirect('admin/users');
        }
    }
}
