<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Address extends Model
{
    use HasFactory;
    protected $table = 'address';

    protected $fillable = [
        'user_id',
        'km',
        'longitude',
        'latitude',
        'landmark',
        'full_address',
        'pincode',
        'recieving_person',
        'recieving_person_mobile_number',
    ];

    public function getKmInUserAddress($address_id)
    {
        $data = Address::select(DB::raw("km"))->where('id',$address_id)->get()->toArray();

        return !empty($data) ? $data[0]['km']:null;
    }
}
