<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator as FacadesValidator;

class APIController extends Controller
{
    // public function userLogin(Request $request){
    //     $name_email = $request->name_email;
    //     $password = $request->password;
        
    //     if(Auth::attempt(['name'=>$name_email,'password'=>$password],$request->remember)){
    //         $user = Auth::user();
    //         $token = $user->createToken($user->name.'-AuthToken')->plainTextToken;
    //         return response()->json([
    //             'status'    => 200,
    //             'token'     => $token
    //         ],200);

    //     }
    //     elseif(Auth::attempt(['email'=>$name_email,'password'=>$password])){
    //         $user = Auth::user();
    //         $token = $user->createToken($user->name.'-AuthToken')->plainTextToken;
    //         return response()->json([
    //             'status'    => 200,
    //             'token'     => $token
    //         ],200);
    //     }
    //     else{
    //         return redirect('/signin')->with('message_fail','Incorrect Name,Email Or Password');
    //     }
    // }


    public function userLoginApi(Request $request)
{
    $validator = FacadesValidator::make($request->all(), [
        'name_email' => 'required|string',
        'password' => 'required|string',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => 422,
            'errors' => $validator->errors()
        ], 422);
    }

    $credentials = ['password' => $request->password];

    $credentials['name'] = $request->name_email;
    if (Auth::attempt($credentials)) {
        $user = Auth::user();
        $token = $user->createToken($user->name . '-AuthToken')->plainTextToken;
        return response()->json([
            'status' => 200,
            'message' => 'Login successful',
            'token' => $token,
            'user' => $user
        ]);
    }

    $credentials = ['email' => $request->name_email, 'password' => $request->password];
    if (Auth::attempt($credentials)) {
        $user = Auth::user();
        $token = $user->createToken($user->name . '-AuthToken')->plainTextToken;
        return response()->json([
            'status' => 200,
            'message' => 'Login successful',
            'token' => $token,
            'user' => $user
        ]);
    }

    return response()->json([
        'status' => 401,
        'message' => 'Incorrect name, email or password'
    ], 401);
}


   

    
    public function listProduct(){
        $dbProduct = DB::table('product')->get();
        if($dbProduct){
            return response()->json([
                'status'    => 200,
                'products'  => $dbProduct
            ]);
        }
    }

    public function addCart(Request $request){
        if (Auth::user()->id != 0) {
            $userId = Auth::user()->id;
            $qty = $request->qty;
            $productId = $request->productId;

            $exist = DB::table('cart')->where('user_id', $userId)->count();

            if ($exist == 0) {
                $insertCart = DB::table('cart')->insert([
                    'user_id'       => $userId,
                    'total_amount'  => 0,
                    'created_at'    => date('Y-m-d h:i:s')
                ]);
                $cartId = DB::table('cart')->where('user_id', $userId)->first();
            
            } else {
                $cartId = DB::table('cart')->where('user_id', $userId)->limit(1)->first();
            }
            $productPrice = DB::table('product')->where('id', $productId)->first();
            if ($productPrice->sale_price > 0) {
                $price = $productPrice->sale_price;
            } else {
                $price = $productPrice->regular_price;
            }

            $cartItem = DB::table('cart_items')
                ->where('cart_id', $cartId->id)
                ->where('product_id', $productId)
                ->where('status', 0)
                ->first();

            if ($cartItem) {
                DB::table('cart_items')->where('id', $cartItem->id)->update([
                    'price'         => $price,
                    'quantity'      => $cartItem->quantity + $qty,
                    'updated_at'    => date('Y-m-d h:i:s')
                ]);
            } else {
                DB::table('cart_items')->insert([
                    'cart_id'       => $cartId->id,
                    'product_id'    => $productId,
                    'price'         => $price,
                    'quantity'      => $qty,
                    'status'        => 0,
                    'created_at'    => date('Y-m-d h:i:s'),
                    'updated_at'    => date('Y-m-d h:i:s')
                ]);
            }



            $totalAmount = $cartId->total_amount + ($price * $qty);

            DB::table('cart')->where('id', $cartId->id)->update([
                'total_amount'  => $totalAmount,
                'updated_at'    => date('Y-m-d h:i:s')
            ]);

            return response()->json([
                'status'    => 200,
                'message'   => "Add Cart Success"
            ],200);
        } else {
            return response()->json([
                'status'    => 500,
                'message'   =>  "Please Login"
            ]);
        }
    }

    public function CartItem()
    {
        $userId = Auth::user()->id;
        $cartId = DB::table('cart')->where('user_id', $userId)->first();

        $cartId = $cartId->id;

        $cartItems = DB::table('cart_items')
            ->leftJoin('product', 'cart_items.product_id', '=', 'product.id')
            ->leftJoin('cart', 'cart.id', 'cart_items.cart_id')
            ->where('cart_items.cart_id', $cartId)
            ->where('status', 0)
            ->select('cart_items.*', 'product.name', 'product.thumbnail', 'cart.total_amount')
            ->get();

        return response()->json([
            'status'    => 200,
            'cart-items'    => $cartItems
        ],200);
    }

    public function placeOrder(Request $request)
    {
        $transactionId = date('Ymdhis');
        $userId = Auth::user()->id;
        $phone = $request->phone;
        $address = $request->address;

        $cart = DB::table('cart')->where('user_id', $userId)->first();


        $cartItems = DB::table('cart_items')->where('cart_id', $cart->id)->where('status', 0)->get();


        $user = DB::table('users')->where('id', $userId)->first();
        $orderId = DB::table('order')->insertGetId([
            'transaction_id' => $transactionId,
            'user_id' => $userId,
            'fullname' => $user->name,
            'phone' => $phone,
            'address' => $address,
            'total_amount' => $cart->total_amount,
            'status' => "pending",
            'created_at'    => date('Y-m-d h:i:s'),
            'updated_at'    => date('Y-m-d h:i:s')
        ]);


        foreach ($cartItems as $cartItem) {
            DB::table('order_item')->insert([
                'order_id' => $orderId,
                'product_id' => $cartItem->product_id,
                'price' => $cartItem->price,
                'quantity' => $cartItem->quantity,
                'created_at'    => date('Y-m-d h:i:s'),
                'updated_at'    => date('Y-m-d h:i:s')
            ]);
        }

        DB::table('cart_items')->where('cart_id', $cart->id)->update([
            'status'    => 1,
            'updated_at'    => date('Y-m-d h:i:s')
        ]);
        DB::table('cart')->where('id', $cart->id)->update([
            'total_amount' => 0,
            'updated_at'    => date('Y-m-d h:i:s')
        ]);
        $orderIdCount = DB::table('order_item')
            ->where('order_id', $orderId)
            ->count('order_id');

        $dbOrderItem = DB::table('order_item')->where('order_id', $orderId)
            ->leftJoin('product', 'product.id', 'order_item.product_id')
            ->leftJoin('order', 'order.id', 'order_item.order_id')
            ->select('product.name', 'product.thumbnail', 'order_item.*', DB::raw('order_item.price * order_item.quantity as total'))
            ->orderByDesc('order.id')
            ->limit($orderIdCount)
            ->get();
        $totalAmount = $dbOrderItem->sum('total');

        return response()->json([
            'status'    => 200,
            'message'   => 'order success'
        ],200);
    }

    public function myOrder(){
        $dbOrder = DB::table('order')->orderByDesc('id')->get();
        return response()->json([
            'status'    => 200,
            'my_order'  => $dbOrder
        ]);
    }

    public function cancelOrder($id)
{
    $dborderCheck = DB::table('order')->where('id', $id)->first();

    if (!$dborderCheck) {
        return response()->json([
            'status' => 404,
            'message' => 'Order not found'
        ]);
    }

    if ($dborderCheck->status == 'pending') {
        $dbOrder = DB::table('order')->where('id', $id)->update([
            'status' => 'cancel',
            'updated_at'    => date('Y-m-d h:i:s')
        ]);

        if ($dbOrder) {
            return response()->json([
                'status' => 200,
                'message' => 'Order cancellation successful'
            ]);
        }
    } else {
        return response()->json([
            'status' => 500,
            'message' => "Can't cancel the order"
        ]);
    }
}


    public function viewOrder($id){
        $dbOrderItems = DB::table('order_item')->where('order_id',$id)
        ->leftJoin('product','product.id','order_item.product_id')
        ->select('product.name','product.thumbnail','order_item.*')
        ->get();
        // return $dbOrderItems;
        $dbOrder = DB::table('order')->where('id',$id)->get();

        return response()->json([
            'status'    => 200,
            'view-order'    => $dbOrderItems
        ]);        
    }

    public function Product($slug)
    {
        $product = DB::table('product')->where('slug', $slug)->first();
        $categoryId = $product->category;
        $currentViewer = $product->viewer;
        $increaseViewer = $currentViewer + 1;
        $productId = $product->id;
        DB::table('product')->where('id', $productId)->update([
            'viewer' => $increaseViewer
        ]);
       
        return response()->json([
            'status'    => 200,
            'product'   => $product
        ]);
    }
}
