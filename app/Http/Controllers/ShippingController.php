<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ShippingOption as ShippingOption;
use View;
use App\Http\Requests;

class ShippingController extends Controller{

    public function create(){
        $shipping = new ShippingOption();
        return View::make('shipping.create')->with('shipping', $shipping);
    }

    public function store(Request $request){
        $this->validate($request, [
            'country' => 'required',
            'country_code' => 'required',
            'weight' => 'required|numeric',
            'price' => 'required|numeric'
        ]);

        ShippingOption::create(
            $request->all()
        );

        $data = [
            'type'    => 'success',
            'message' => 'Shipping option successfully created !'
        ];

        return View::make('message')->with($data);
    }
}
