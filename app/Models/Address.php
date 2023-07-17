<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;
    protected $table = 'address';

    protected $fillable = [
        'user_id',
        'longitude',
        'latitude',
        'full_address',
        'pincode',
        'recieving_person',
        'recieving_person_mobile_number',
    ];

    public function getOnlyCartIds($user_id,$address_id)
    {
        $data = Address::select(DB::raw("km"))->where('user_id',$user_id)->where('id',$address_id)->get();
        return $data;
    }
}
