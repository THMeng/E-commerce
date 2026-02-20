<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AccessUserController extends Controller
{
    public function accessOrder(){
        $dbOrder = DB::table('order')->where('status','pending')->get();
        $order = DB::table('order')->where('status', 'pending')->count();
        return view('backend.access-order',['order'=>$dbOrder , 'orderRow'=>$order]);
    }

    public function accessSubmit($id){
        $access = DB::table('order')->where('id',$id)->update([
            'status'    => 'complete',
            'updated_at' => date('Y-m-d h:i:s')
        ]);
        if($access){
            return redirect('/admin/list-order');
        }
    }

    public function listOrder(){
        $dbOrder = DB::table('order')->get();
        $order = DB::table('order')->where('status', 'pending')->count();
        return view('backend.list-order',['order'=>$dbOrder , 'orderRow'=>$order]);
        
    }

    public function rejectOrder(Request $request){
        $access = DB::table('order')->where('id',$request->id)->update([
            'status'    => 'reject',
            'updated_at' => date('Y-m-d h:i:s')
        ]);

        $dbOrderItem = DB::table('order_item')->where('order_id',$request->id)->get();

        foreach ($dbOrderItem as $orderItem) {
            DB::table('product')->where('id', $orderItem->product_id)->increment('quantity', $orderItem->quantity);
        }

        if($access){
            return redirect('/admin/list-order');
        }
    }
}
