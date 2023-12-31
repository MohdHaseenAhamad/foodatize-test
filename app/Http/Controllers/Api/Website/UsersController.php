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
            $phone_number = $request->phone_number;
            $otp = mt_rand(10000, 99999);
            $data = [
                'phone_number'=>$phone_number,
                'phone_otp'=>$otp,
                'phone_otp_time'=>date('Y-m-d H:i:s'),
            ];
            $response = $this->sentOtpOnMobile($phone_number,$otp);
            $result = User::createUser($data);
            $formateData = new UserResource($result['data']);
            if (!empty($result)) {
                return response()->json(['status' => 200, 'massage' => $response, 'data' => $formateData, 'user_type' => $result['user_type']], 200);
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
            $results = User::where('phone_number', '=', $request->phone_number)->where('phone_otp', '=', $request->phone_otp)->get()->toArray();
            $token = hash('sha256', $plainTextToken = Str::random(40));
            if (count($results) > 0)
            {
                $data = [
                    'phone_status'=>1,
                    'token'=>$token
                ];
                $status = User::where('phone_number', '=', $request->phone_number)->where('phone_otp', '=', $request->phone_otp)->update($data);
                $result = User::where('phone_number', '=', $request->phone_number)->where('phone_otp', '=', $request->phone_otp)->get();
                return response()->json([
                    'access_token' => $token,
                    'status' => 200, 'massage' => 'user verification is successfully', 'data' => $result,
                ]);

            } else {
                return response()->json([
                    'status' => 400,
                    'message' => 'user verification otp not match',
                ], 400);
            }

        }
    }
    public function reSendOTP(Request $request)
    {
        $token = hash('sha256', $plainTextToken = Str::random(40));
        $otp= mt_rand(10000, 99999);
        $phone_number = $request->phone_number;
        $data = [
            'phone_otp'=>$otp,
            'phone_otp_time'=>date('Y-m-d H:i:s'),
            'phone_status'=>0,
            'token'=>$token
        ];
        $status = User::where('phone_number', '=', $phone_number)->update($data);
        if($status)
        {
            $results = User::where('phone_number', '=', $phone_number)->get();
            $response = $this->sentOtpOnMobile($phone_number,$otp);
            return response()->json([
                'access_token' => $token,
                'status' => 200, 'massage' => $response, 'data' => $results,
            ]);
        }
        else
        {
            return response()->json([
                'status' => 400,
                'message' => 'user verification otp not send please try again',
            ], 400);
        }
    }


    public function saveBasicInfo(Request $request, $id)
    {
        if ((new UsersController())->checkUserStatus($id)) {
            $phoneNumberExistOrNot = User::where('email', '=', $request->email)->exists();
            if ($phoneNumberExistOrNot) {
                return response()->json([
                    'status' => 200,
                    'message' => 'your email is already exist.',
                ], 200);
            } else {
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
        }else
        {
            return response()->json([
                'status' => 401,
                'message' => 'Unauthorized Customer.',
            ], 401);
        }


    }


    /**
     * Display the specified resource.
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        if ((new UsersController())->checkUserStatus($id))
        {
            $user_info = User::where('id', $id)->get();
            if (!empty($user_info)) {
                return response()->json(['status' => 200, 'message' => 'user information found.', 'data' => $user_info], 200);
            } else {
                return response()->json([
                    'status' => 400,
                    'message' => 'user information not found.',
                ], 400);
            }
        }
        else
        {
            return response()->json([
                'status' => 401,
                'message' => 'Unauthorized Customer.',
            ], 401);
        }
    }

    /**
     * Show the form for editing the specified resource.
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        if ((new UsersController())->checkUserStatus($id)) {
            $validator = validator::make($request->all(), [
                'name' => ['required', 'min:2', 'max:100'],
                'email' => ['required', 'email', 'max:100'],
                'phone_number' => ['required', 'min:10', 'max:10'],
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
                    'email' => $request->email,
                    'phone_number' => $request->phone_number,
                ];
                if ($request->phone_number == $request->phone_number_old) {
                    $retVal = User::where('id', $id)->update($data);
                    if ($retVal) {
                        return response()->json([
                            'status' => 200,
                            'message' => 'user information is successfully update.',
                            'data' => User::where('id', $id)->get(),
                        ], 200);
                    } else {
                        return response()->json([
                            'status' => 400,
                            'message' => 'user information not found.',
                        ], 400);
                    }
                } else {
                    $data['phone_otp'] = mt_rand(10000, 99999);
                    $data['phone_otp_time'] = date('Y-m-d H:i:s');
                    $data['phone_number'] = $request->phone_number;
                    $data['phone_status'] = 0;
                    $this->sentOtpOnMobile($request->phone_number, $data['phone_otp']);
                    $retVal = User::where('id', $id)->update($data);
                    if ($retVal) {
                        return response()->json([
                            'status' => 202,
                            'message' => 'your otp send successfully.',
                            'data' => $data,
                        ], 202);
                    } else {
                        return response()->json([
                            'status' => 400,
                            'message' => 'user information not found.',
                        ], 400);
                    }
                }
            }
        }
        else
        {
            return response()->json([
                'status' => 401,
                'message' => 'Unauthorized Customer.',
            ], 401);
        }

    }

    /**
     * Remove the specified resource from storage.
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }
    public function loginWithMobile(Request $request){
        /*Message Sending NEW Function*/

        function _SEND_MESSAGE_NEW($phone = "7309589697", $msg = "Hii, Test Message", $template_id = "1207165849293899310")
        {

            $api_key = '4606EA01F14FA4';
            $contacts = $phone;
            $from = 'CYBSMS';
            $sms_text = urlencode($msg);
            $pe_id = '1201161588202057139';
            $template_id = $template_id;

            $api_url = "http://kutility.org/app/smsapi/index.php?key=" . $api_key . "&campaign=11291&routeid=7&type=text&contacts=" . $contacts . "&senderid=" . $from . "&msg=" . $sms_text . "&template_id=" . $template_id . "&pe_id=" . $pe_id;

            //Submit to server

            $response = file_get_contents($api_url);
            // echo $response;

        }

        // $phone = $request['phone'];
        $otp =  '123456';
        $phone = 7309589697;
        $msg = "Your one-time password for authentication is: " . $otp . " - YonoDeal";

        $res = _SEND_MESSAGE_NEW($phone, $msg, "1207166920306621719");



        $response = [

            'success' => 'Otp sent to your mobile no',
            'status' => true
        ];
        return response($response, 201);
    }

    public function sentOtpOnMobile($phone_number,$phone_otp){
        /*Message Sending NEW Function*/

        function _SEND_MESSAGE_NEW($phone_number, $msg = "Hii, Test Message", $template_id = "1207165849293899310")
        {

            $api_key = '4606EA01F14FA4';
            $contacts = $phone_number;
            $from = 'CYBSMS';
            $sms_text = urlencode($msg);
            $pe_id = '1201161588202057139';
            $template_id = $template_id;

            $api_url = "http://kutility.org/app/smsapi/index.php?key=" . $api_key . "&campaign=11291&routeid=7&type=text&contacts=" . $contacts . "&senderid=" . $from . "&msg=" . $sms_text . "&template_id=" . $template_id . "&pe_id=" . $pe_id;

            //Submit to server

            $response = file_get_contents($api_url);
            // echo $response;

        }

        // $phone = $request['phone'];
        $otp =  $phone_otp;
        $phone = $phone_number;
        $msg = "Your one-time password for authentication is: " . $otp . " - YonoDeal";

        $res = _SEND_MESSAGE_NEW($phone, $msg, "1207166920306621719");



        $response = [

            'success' => 'Otp sent to your mobile no',
            'status' => true
        ];
        return 'Otp sent to your mobile no';
    }

    public function checkUserStatus($user_id)
    {
       $status = User::where('id',$user_id)->select('phone_status')->get();
       if(intval($status[0]->phone_status) > 0)
       {
          return true;
       }
       else
       {
           return false;
       }
    }
}
