<?php

namespace App\Http\Controllers\Vtt;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vtt\Item; //use the Model Post
use Auth;

class BarcodegeneratorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function barcode()
    {
        if (Auth::check()) {
            // user is logged in
            $store_id = auth()->user()->store_id;
        } else {
            return redirect()->guest(route('login'));
        }

        $item = Item::where('store_id', $store_id);

        return view('pos.barcodegenerator')
             ->with('item',$item);
    }

    public function generateBarcode(Request $request){
        $id = $request->get('id');
        $item = Item::find($id);
        return view('barcode')->with('item',$item);
    }
}
