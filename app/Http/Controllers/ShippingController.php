<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ShippingOption as ShippingOption;
use View;
use App\Http\Requests;

class ShippingController extends Controller{

    public function index(){
        $shipping_options = ShippingOption::orderBy('id', 'desc')->get();
        $data = [
            'shipping_options'  => $shipping_options
        ];

        return View::make('shipping.index')->with($data);
    }

    public function create(){
        $shipping = new ShippingOption();
        $data = [
            'shipping' => $shipping,
            'method' => 'post',
            'route' => 'shipping.store'
        ];
        return View::make('shipping.create')->with($data);
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

    public function edit($id){
        $shipping_option = ShippingOption::where('id', $id)->first();
        if (!$shipping_option){
            return abort(404, "Shipping $id not found");
        };
        $data = array(
            'shipping' => $shipping_option,
            'method' => 'put',
            'route' => 'shipping.update'
        );
        return View::make('shipping.create_or_edit')->with($data);
    }

    public function update(Request $request, $id){
        $shipping_option = ShippingOption::where('id', $id)->first();
        $shipping_option->update( $request->all() );
        $shipping_option->save();
        
        return redirect()->route('shipping.index');
    }

    public function destroy($id){

        ShippingOption::where('id', $id)->first()->delete();

        $data = [
            'type'    => 'success',
            'message' => 'Shipping option successfully deleted !'
        ];

        return back();
    }
}
