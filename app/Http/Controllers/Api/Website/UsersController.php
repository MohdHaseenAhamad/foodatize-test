<?php

namespace App\Http\Controllers\Api\Website;

use App\Http\Controllers\Controller;
//use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
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

    public function registerUsers() {

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
    public function store(Request $request) {


        $validator = validator::make($request->all(), [
            'phone_number' => ['required', 'min:10', 'max:10'],
            'phone_otp' => ['required', 'min:6', 'max:6'],
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
            $result = User::createUser($request->all());
            $formateData = new UserResource($result['data']);
            return response()->json(['status' => 200, 'massage' => '', 'data' => $formateData, 'user_type' => $result['user_type']], 200);
        }

    }

    public function otpVerification(Request $request) {
        $credentials = $request->only('phone_number', 'phone_otp');

//        $credentials = $this->credentials($request);

//        $token = auth('api')->attempt($credentials);
//        dd($token);
        $validator = validator::make($request->all(), [
            'phone_otp' => ['required', 'min:6', 'max:6'],
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
            $retval = User::otpVerification($request->all());
            if(JWTAuth\JWTAuth::attempt(['phone_number' => $request->phone_number, 'verification_code' => $request->phone_otp])){
//                $user = User::user();
                $success['token'] =  $retval->createToken('App')->accessToken;
                return response()->json(['success' => $success], 200);
            }
            else{
                return response()->json(['error'=>'Unauthorised'], 401);
            }
            if (!empty($retval)) {

//                $otp = $request->phone_otp;
//                $phone = $request->phone_number;
//                $credentials = [
//                    'phone_otp'=>$otp,
//                    'phone_number'=>$phone,
//                    ];
                // you may skip the 'api' if you set your default guard
//                $token = auth('api')->attempt([
//                    'phone_otp'    => $otp,
//                    'phone_number' => $phone,
//                ]);
                try {
                    if (!$userToken = JWTAuth\JWTAuth::attempt($credentials)) {
                        return response()->json(['error' => 'invalid_credentials'], 401);
                    }
                }catch (JWTException $e) {
                    return $credentials;
                    return response()->json([
                        'success' => false,
                        'message' => 'Could not create token.',
                    ], 500);
                }
//                dd($retval);
//                return response()->json(compact('userToken'));
//                if($userToken==false)
//                {
//                    return response()->json(['status' => 400,'message'=>'Unauthorized user']);
//                }else
//                {
//                    return response()->json(['status' => 200, 'massage' => 'Your otp is correct', 'data' => $retval,'access_token' => $userToken, 'token_type' => 'bearer',
//                        'expires_in' => auth('api')->factory()->getTTL() * 60], 200);
//                }

            }else{
                return response()->json(['status' => 400, 'massage' => 'Your otp is not correct', 'data' => $retval], 400);
            }

        }
    }

    public function saveBasicInfo(Request $request)
    {
        $validator = validator::make($request->all(), [
            'name' => ['required', 'min:2', 'max:100'],
            'email' => ['required', 'email', 'max:100'],
        ], [
            'required' => ':attribute is required.',
            'min' => 'Please enter at least :min characters',
            'max' => 'Please enter less then :max characters',
        ]);

    }
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
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
