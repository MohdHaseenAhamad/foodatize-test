<?php

namespace App\Http\Controllers\Api\Website;

use App\Http\Controllers\Controller;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AddressContoller extends Controller {
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index() {

    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     */
    public function create() {

    }

    /**
     * Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $validator = validator::make($request->all(), [
            'longitude' => ['required', 'min:2', 'max:30'],
            'latitude' => ['required', 'min:2', 'max:30'],
            'full_address' => ['required', 'min:2', 'max:250'],
            'pincode' => ['required', 'min:6', 'max:6'],
            'recieving_person' => ['required', 'min:2', 'max:100'],
            'recieving_person_mobile_number' => ['required', 'min:10', 'max:10'],
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

            $adb = Address::create($request->all());
            $data = Address::find($adb->id);
            return response()->json([
                'status' => 200,
                'message' => "address add Successfully",
                'data' => $data,
            ], 200);
        }
    }

    /**
     * Display the specified resource.
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $data = Address::where('user_id',$id)->get();
        return response()->json([
            'status' => 200,
            'message' => "address fetch Successfully",
            'data' => $data,
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $data = Address::find($id);
        return response()->json([
            'status' => 200,
            'message' => "address fetch Successfully",
            'data' => $data,
        ], 200);
    }



    /**
     * Update the specified resource in storage.
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
//        dd($request->all());
        $validator = validator::make($request->all(), [
            'longitude' => ['required', 'min:2', 'max:30'],
            'latitude' => ['required', 'min:2', 'max:30'],
            'full_address' => ['required', 'min:2', 'max:250'],
            'pincode' => ['required', 'min:6', 'max:6'],
            'recieving_person' => ['required', 'min:2', 'max:100'],
            'recieving_person_mobile_number' => ['required', 'min:10', 'max:10'],
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
                'longitude' => $request->longitude,
                'latitude' => $request->latitude,
                'full_address' =>$request->full_address,
                'km'=>$request->km,
                'pincode' => $request->pincode,
                'recieving_person' =>$request->recieving_person ,
                'recieving_person_mobile_number' => $request->recieving_person_mobile_number,
            ];
            $adb = Address::where('id', $id)->update($data);
//            dd($adb);
            if ($adb > 0) {
                $data = Address::find($id); /*Fetch Data Using Id  */
                return response()->json([
                    'status' => 200,
                    'message' => "address update Successfully",
                    'data' => $data,
                ], 200);
            } else {
                return response()->json([
                    'status' => 400,
                    'message' => 'something went wrong',
                ], 400);
            }
        }
    }

    public function getPrice(Request $request)
    {
        $km  =$request->km;
        if($km <= 2)
        {
            return response()->json([
                'status' => 200,
                'message' => "your price get Successfully",
                'data' => 'Free',
            ], 200);
        }
        else
        {
            $value = (int)($km / 2);
            $value = $value * 5;
            return response()->json([
                'status' => 200,
                'message' => "your price get Successfully",
                'data' => $value,
            ], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        if($id) {
            $addressRemove = Address::findOrFail($id)->delete();
            if($addressRemove)
            {
                return response()->json([
                    'status' => 200,
                    'message' => 'delete address successfully',
                    'data'=>session()->get('cart')
                ], 200);
            }
            else
            {
                return response()->json([
                    'status' => 400,
                    'message' => 'something went wrong',
                ], 400);
            }

        }
    }
}
