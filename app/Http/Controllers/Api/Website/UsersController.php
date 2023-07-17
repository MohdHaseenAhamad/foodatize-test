<?php

namespace App\Http\Controllers\Api\Website;

use App\Http\Controllers\Controller;
//use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Tymon\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

use Illuminate\Auth\Authenticatable;

class UsersController extends Controller {
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //
    }



    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function registerUsers(Request $request) {

        $validator = validator::make($request->all(), [
            'phone_number' => ['required', 'min:10', 'max:10'],
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
            $data = [
                'phone_number'=>$request->phone_number,
                'phone_otp'=>mt_rand(10000, 99999),
                'phone_otp_time'=>date('Y-m-d H:i:s'),
            ];
            $result = User::createUser($data);
            $formateData = new UserResource($result['data']);
            if (!empty($result)) {
                return response()->json(['status' => 200, 'massage' => 'user registration successfully.', 'data' => $formateData, 'user_type' => $result['user_type']], 200);
            } else {
                return response()->json([
                    'status' => 400,
                    'message' => 'something went wrong',
                ], 400);
            }

        }

    }

    public function otpVerification(Request $request) {

        $validator = validator::make($request->all(), [
            'phone_otp' => ['required', 'min:5', 'max:5'],
            'phone_number' => ['required', 'min:10', 'max:10'],
        ], [
            'required' => ':attribute is required.',
            'min' => 'Please enter at least :min characters',
            'max' => 'Please enter less then :max characters',
        ]);  /*Add Users Validation*/
//
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => $validator->messages(),
            ], 400);
        } else {
            $results= User::otpVerification($request->all());
            if (count($results) > 0) {
                $token = hash('sha256', $plainTextToken = Str::random(40));
                $status = User::where('phone_number', '=', $request->phone_number)->where('phone_otp', '=', $request->phone_otp)->update(['phone_status'=>1,'token'=>$token]);
                return response()->json([
                    'access_token' => $token,
                    'status' => 200, 'massage' => 'user verification is successfully', 'data' => $results,
                ]);

            } else {
                return response()->json([
                    'status' => 400,
                    'message' => 'user verification otp not match',
                ], 400);
            }

        }
    }

    public function saveBasicInfo(Request $request, $id) {
        $validator = validator::make($request->all(), [
            'name' => ['required', 'min:2', 'max:100'],
            'email' => ['required', 'email', 'max:100'],
        ], [
            'required' => ':attribute is required.',
            'min' => 'Please enter at least :min characters',
            'max' => 'Please enter less then :max characters',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => $validator->messages(),
            ], 400);
        } else {
            $data = [
                'name' => $request->name,
                'email' => $request->email
            ];
            $data = User::saveBasicInfo($data, $id);
            if (!empty($data)) {
                return response()->json(['status' => 200, 'massage' => 'update_successfully', 'data' => $data], 200);
            } else {
                return response()->json([
                    'status' => 400,
                    'message' => 'something went wrong',
                ], 400);
            }

        }


    }


    /**
     * Display the specified resource.
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {

    }

    /**
     * Show the form for editing the specified resource.
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
    }
}
