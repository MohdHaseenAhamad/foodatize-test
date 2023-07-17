<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cart extends Model
{
    use HasFactory;
    protected $table = 'cart';

    public function totalCountProductByUser($user_id)
    {
        $count = Cart::where('user_id',$user_id)->get();
        return $count->count();
    }
    public function totalProductPriceCountByUser($user_id)
    {

        $data = Cart::select(DB::raw("SUM(price*quantity) as total_count"))->where('user_id',$user_id)->get();
        return $data;
    }

    public function getOnlyCartIds($user_id)
    {
        $data = Cart::select(DB::raw(" GROUP_CONCAT(id)"))->where('user_id',$user_id)->get();
        return $data;
    }
}
