<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable {
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     * @var array<int, string>
     */
    protected $fillable = [
        'phone_number',
        'phone_otp',
    ];

    /**
     * The attributes that should be hidden for serialization.
     * @var array<int, string>
     */
//    protected $hidden = [
//        'password',
//        'remember_token',
//    ];

    /**
     * The attributes that should be cast.
     * @var array<string, string>
     */
//    protected $casts = [
//        'email_verified_at' => 'datetime',
//    ];
    public function createUser($request) {
//
        $phoneNumberExistOrNot=User::where('phone_number', '=', $request['phone_number'])->exists();
        if($phoneNumberExistOrNot)
        {

            $result['data'] = User::where('phone_number', $request['phone_number'])->first();
            $result['user_type'] = 'old';
        }else
        {
            $users =User::create($request);
            $result['data'] = User::find($users->id); /*Fetch Data Using Id  */
            $result['user_type']= 'new';
        }
        /*Store Data */

        return $result;
    }

}
