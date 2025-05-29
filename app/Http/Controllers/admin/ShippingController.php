<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\ShippingCharge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ShippingController extends Controller
{
    public function getShipping(){  

        $shipping = ShippingCharge::first();
        return response()->json([
            'status' =>200,
            'data' => $shipping
        ],200);
    }

    public function updateShipping(Request $request){
        $validator = Validator::make($request->all(),[
            'shipping_charges' =>  'required|numeric'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'errors' =>$validator->errors()
            ],400);
        }

        $shipping = ShippingCharge::find(1);

        if($shipping == null){
            $model = new ShippingCharge();
            $model->shipping_charges = $request->shipping_charges;
            $model->save();
        }else{
             $shipping->shipping_charges = $request->shipping_charges;
             $shipping->save();
        }

          return response()->json([
                'status' => 200,
                'message' => "shipping saved successfully"
          ],200);
    }
}


