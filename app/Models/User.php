<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject {
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     * @var array<int, string>
     */
    protected $fillable = [
        'phone_number',
        'phone_otp',
        'name',
        'email',
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
    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     * @return mixed
     */
    public function getJWTIdentifier() {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     * @return array
     */
    public function getJWTCustomClaims() {
        return [];
    }

    public function createUser($request) {
//
        $phoneNumberExistOrNot = User::where('phone_number', '=', $request['phone_number'])->exists();
        if ($phoneNumberExistOrNot) {

            $result['data'] = User::where('phone_number', $request['phone_number'])->first();
            $result['user_type'] = 'old';
        } else {
            $users = User::create($request);
            $result['data'] = User::find($users->id); /*Fetch Data Using Id  */
            $result['user_type'] = 'new';
        }
        /*Store Data */

        return $result;
    }

    public function otpVerification($request) {
        $result = User::where('phone_number', '=', $request['phone_number'])->where('phone_otp', '=', $request['phone_otp'])->get()->toArray();

        if (count($result) > 0) {

            return $result;
        }
        return false;
    }
    public function updateUserStatus($request,$data) {
        $result = User::where('phone_number', '=', $request['phone_number'])->where('phone_otp', '=', $request['phone_otp'])->get()->toArray();

        if (count($result) > 0) {
            return $result;
        }
        return false;
    }

    public function saveBasicInfo($data, $id) {
        $result = User::where('id', $id)->update($data);
        if ($result > 0) {
            $results = User::find($id); /*Fetch Data Using Id  */
            return $results;
        }
        return false;
    }

}
