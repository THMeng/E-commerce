<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{

    public function Home()
    {
        $logo = DB::table('logo')->get();

        $newProducts = DB::table('product')
            ->orderBy('created_at', 'desc')
            ->limit(8)
            ->get();

        $promotionPro = DB::table('product')
            ->where('sale_price', '>', 0)
            ->orderBy('created_at', 'desc')
            ->limit(8)
            ->get();

        $popularProduct = DB::table('product')
            ->orderBy('created_at', 'asc')
            ->limit(8)
            ->get();

        $favIds = $this->getFavIds();
        $this->attachFav($newProducts,    $favIds);
        $this->attachFav($promotionPro,   $favIds);
        $this->attachFav($popularProduct, $favIds);

        return view('frontend.home', compact(
            'logo',
            'newProducts',
            'promotionPro',
            'popularProduct'
        ));
    }



    public function Shop(Request $request)
{
    $limitPage   = 6;
    $currentPage = $request->input('page', 1);
    $offset      = ($currentPage - 1) * $limitPage;

    $productObj = DB::table('product');

    if ($request->category) {
        $categorySlug = $request->category;
        $categoryId   = DB::table('category')->where('slug', $categorySlug)->first();
        $productObj->where('category', $categoryId->id);
        $productCount = DB::table('product')->where('category', $categoryId->id)->count();
    } elseif ($request->price) {
        if ($request->price == 'max') {
            $productObj->orderByDesc('regular_price');
        } else {
            $productObj->orderBy('regular_price', 'ASC');
        }
        $productCount = DB::table('product')->count();
    } elseif ($request->promotion) {
        $productObj->where('sale_price', '>', 0);
        $productCount = DB::table('product')->where('sale_price', '>', 0)->count();
    } else {
        $productCount = DB::table('product')->count();
    }

    $product  = $productObj->orderByDesc('id')->limit($limitPage)->offset($offset)->get();
    $category = DB::table('category')->orderByDesc('id')->get();
    $totalPage = ceil($productCount / $limitPage);

    $favIds = [];
    if (Auth::check()) {
        $favIds = DB::table('favorites')
            ->where('user_id', Auth::user()->id)
            ->pluck('product_id')
            ->toArray();
    }

    return view('frontend.shop', [
        'product'   => $product,
        'totalPage' => $totalPage,
        'category'  => $category,
        'favIds'    => $favIds,
    ]);
}

public function Product($slug)
{
    $product = DB::table('product')->where('slug', $slug)->get();
    if (count($product) == 0) {
        return redirect('/404');
    }

    $categoryId    = $product[0]->category;
    $currentViewer = $product[0]->viewer;
    $productId     = $product[0]->id;

    DB::table('product')->where('id', $productId)->update([
        'viewer' => $currentViewer + 1
    ]);

    $relatedProduct = DB::table('product')
        ->where('category', $categoryId)
        ->where('id', '<>', $productId)
        ->limit(4)
        ->orderByDesc('id')
        ->get();

    // Favorite IDs for logged-in user
    $favIds = [];
    if (Auth::check()) {
        $favIds = DB::table('favorites')
            ->where('user_id', Auth::user()->id)
            ->pluck('product_id')
            ->toArray();
    }

    return view('frontend.product', [
        'product'        => $product,
        'relatedProduct' => $relatedProduct,
        'favIds'         => $favIds,
    ]);
}
    
    // public function ShopDetail($slug)
    // {
    //     $product = DB::table('product')->where('slug', $slug)->get();
    //     if (count($product) == 0) {
    //         return redirect('/404');
    //     }
    //     $categoryId = $product[0]->category;
    //     $currentViewer = $product[0]->viewer;
    //     $increaseViewer = $currentViewer + 1;
    //     $productId = $product[0]->id;
    //     DB::table('product')->where('id', $productId)->update([
    //         'viewer' => $increaseViewer
    //     ]);
    //     $relatedProduct = DB::table('product')->where('category', $categoryId)->where('id', '<>', $productId)->limit(4)->orderByDesc('id')->get();
    //     return view('frontend.product', ['product' => $product, 'relatedProduct' => $relatedProduct]);
    // }

    public function News()
    {
        return view('frontend.news');
    }

    public function Article()
    {
        return view('frontend.news-detail');
    }

    public function Search(Request $request)
{
    $keyword  = $request->get('s');
    $products = collect();

    if ($keyword) {
        $products = DB::table('product')
            ->where(function($q) use ($keyword) {
                $q->where('name', 'LIKE', '%' . $keyword . '%')
                  ->orWhere('description', 'LIKE', '%' . $keyword . '%');
            })
            ->get();
    }

    return view('frontend.search', [
        'products' => $products,
        'keyword'  => $keyword,
    ]);
}

public function SearchAjax(Request $request)
{
    $keyword = $request->get('s');

    if (!$keyword || strlen($keyword) < 2) {
        return response()->json([]);
    }

    $products = DB::table('product')
        ->where(function($q) use ($keyword) {
            $q->where('name', 'LIKE', '%' . $keyword . '%')
              ->orWhere('description', 'LIKE', '%' . $keyword . '%');
        })
        ->select('name', 'slug', 'thumbnail', 'regular_price', 'sale_price')
        ->limit(8)
        ->get();

    return response()->json($products);
}

    public function notFound()
    {
        return view('frontend.404');
    }


    public function AddCart(Request $request)
    {
        if ($request->userId != 0) {
            $userId = $request->userId;
            $qty = $request->qty;
            $productId = $request->proId;

            $exist = DB::table('cart')->where('user_id', $userId)->count();

            if ($exist == 0) {
                $insertCart = DB::table('cart')->insert([
                    'user_id'       => $userId,
                    'total_amount'  => 0,
                    'created_at'    => date('Y-m-d h:i:s')
                ]);
                $cartId = DB::table('cart')->where('user_id', $userId)->get();
            } else {
                $cartId = DB::table('cart')->where('user_id', $userId)->limit(1)->get();
            }
            $productPrice = DB::table('product')->where('id', $productId)->get();
            if ($productPrice[0]->sale_price > 0) {
                $price = $productPrice[0]->sale_price;
            } else {
                $price = $productPrice[0]->regular_price;
            }

            $cartItem = DB::table('cart_items')
                ->where('cart_id', $cartId[0]->id)
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
                    'cart_id'       => $cartId[0]->id,
                    'product_id'    => $productId,
                    'price'         => $price,
                    'quantity'      => $qty,
                    'status'        => 0,
                    'created_at'    => date('Y-m-d h:i:s'),
                    'updated_at'    => date('Y-m-d h:i:s')
                ]);
            }

            $totalAmount = $cartId[0]->total_amount + ($price * $qty);

            DB::table('cart')->where('id', $cartId[0]->id)->update([
                'total_amount'  => $totalAmount,
                'updated_at'    => date('Y-m-d h:i:s')
            ]);

            return redirect('/cart-item');
        } else {
            return redirect('/signin');
        }
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
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s')
    ]);

    foreach ($cartItems as $cartItem) {
        // Insert into order_item table
        DB::table('order_item')->insert([
            'order_id' => $orderId,
            'product_id' => $cartItem->product_id,
            'price' => $cartItem->price,
            'quantity' => $cartItem->quantity,
            'created_at' => date('Y-m-d h:i:s'),
            'updated_at' => date('Y-m-d h:i:s')
        ]);

        // Update the product quantity
        DB::table('product')->where('id', $cartItem->product_id)->decrement('quantity', $cartItem->quantity);
    }

    DB::table('cart_items')->where('cart_id', $cart->id)->update([
        'status' => 1,
        'updated_at' => date('Y-m-d h:i:s')
    ]);

    DB::table('cart')->where('id', $cart->id)->update([
        'total_amount' => 0,
        'updated_at' => date('Y-m-d h:i:s')
    ]);

    $orderIdCount = DB::table('order_item')->where('order_id', $orderId)->count('order_id');

    $dbOrderItem = DB::table('order_item')->where('order_id', $orderId)
        ->leftJoin('product', 'product.id', 'order_item.product_id')
        ->leftJoin('order', 'order.id', 'order_item.order_id')
        ->select('product.name', 'product.thumbnail', 'order_item.*', DB::raw('order_item.price * order_item.quantity as total'))
        ->orderByDesc('order.id')
        ->limit($orderIdCount)
        ->get();

    $totalAmount = $dbOrderItem->sum('total');

    return redirect('/recipt')->with([
        'success' => 'Order placed successfully.',
        'orderItems' => $dbOrderItem,
        'totalAmount' => $totalAmount
    ]);
}

public function CartItem()
{
    $userId = Auth::user()->id;

    $cart = DB::table('cart')->where('user_id', $userId)->first();

    if (!$cart) {
        return view('frontend.cart-item', ['cartItems' => collect(), 'totalAmount' => 0]);
    }

    $cartItems = DB::table('cart_items')
        ->leftJoin('product', 'cart_items.product_id', '=', 'product.id')
        ->where('cart_items.cart_id', $cart->id)
        ->where('cart_items.status', 0)
        ->select('cart_items.*', 'product.name', 'product.thumbnail')
        ->get();

    $totalAmount = $cart->total_amount ?? 0;

    return view('frontend.cart-item', ['cartItems' => $cartItems, 'totalAmount' => $totalAmount]);
}
    

    public function myOrder(){
        $userId = Auth::user()->id;
        $dbOrder = DB::table('order')->where('user_id', $userId)->orderByDesc('id')->paginate(5);
        return view('frontend.my-order',['myOrder'=>$dbOrder]);
    }

    public function viewOrder($id){
        $dbOrderItems = DB::table('order_item')->where('order_id',$id)
        ->leftJoin('product','product.id','order_item.product_id')
        ->select('product.name','product.thumbnail','order_item.*')
        ->get();
        $dbOrder = DB::table('order')->where('id',$id)->get();

        return view('frontend.my-order-history',['orderItems'=>$dbOrderItems , 'order'=>$dbOrder]);        
    }

    public function cancelOrder($id)
{
    $dbOrder = DB::table('order')->where('id', $id)->update([
        'status'     => 'cancel',
        'updated_at' => date('Y-m-d H:i:s')  // ✅ fixed: H not h
    ]);

    if (!$dbOrder) {
        return redirect('/my-order')->with('error', 'Order not found or already cancelled.');
    }

    $dbOrderItems = DB::table('order_item')->where('order_id', $id)->get();

    foreach ($dbOrderItems as $orderItem) {
        // ✅ Restore product stock
        DB::table('product')
            ->where('id', $orderItem->product_id)
            ->increment('quantity', $orderItem->quantity);

        // ✅ Reset cart_item status back to 0 (active) so it shows in cart again
        DB::table('cart_items')
            ->where('product_id', $orderItem->product_id)
            ->where('status', 1)
            ->update([
                'status'     => 0,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
    }

    // ✅ Recalculate cart total after restoring items
    // Find the user's cart via the order
    $order = DB::table('order')->where('id', $id)->first();
    if ($order) {
        $cart = DB::table('cart')->where('user_id', $order->user_id)->first();
        if ($cart) {
            $newTotal = DB::table('cart_items')
                ->where('cart_id', $cart->id)
                ->where('status', 0)
                ->sum(DB::raw('price * quantity'));

            DB::table('cart')->where('id', $cart->id)->update([
                'total_amount' => $newTotal,
                'updated_at'   => date('Y-m-d H:i:s')
            ]);
        }
    }

    return redirect('/my-order')->with('success', 'Order cancelled successfully.');
}

    public function checkOut()
    {
        $userId = Auth::user()->id;

        $cart = DB::table('cart')->where('user_id', $userId)->first();

        if (!$cart) {
            return view('frontend.check-out', ['cartItems' => collect(), 'totalAmount' => 0]);
        }

        $cartItems = DB::table('cart_items')
            ->leftJoin('product', 'cart_items.product_id', '=', 'product.id')
            ->where('cart_items.cart_id', $cart->id)
            ->where('cart_items.status', 0)
            ->select('cart_items.*', 'product.name', 'product.thumbnail')
            ->get();

        $totalAmount = $cart->total_amount ?? 0;

        return view('frontend.check-out', ['cartItems' => $cartItems, 'totalAmount' => $totalAmount]);
    }

    public function recipt()
    {
        return view('frontend.recipt');
    }




    public function RemoveCartItems($id)
{
    $cartItem = DB::table('cart_items')->where('id', $id)->first();

    if (!$cartItem) {
        return redirect('/cart-item')->with('error', 'Cart item not found.');
    }

    $cartId = $cartItem->cart_id;

    $delete = DB::table('cart_items')->where('id', $id)->delete();

    if ($delete) {
        // ✅ Only sum active (status=0) items — excludes already-ordered items
        $totalAmount = DB::table('cart_items')
            ->where('cart_id', $cartId)
            ->where('status', 0)
            ->sum(DB::raw('price * quantity'));

        DB::table('cart')->where('id', $cartId)->update([
            'total_amount' => $totalAmount,
            'updated_at'   => date('Y-m-d H:i:s')  // ✅ fixed: H (24hr) not h (12hr)
        ]);

        $remainingItems = DB::table('cart_items')
            ->where('cart_id', $cartId)
            ->where('status', 0)
            ->count();

        if ($remainingItems > 0) {
            return redirect('/cart-item')->with('success', 'Cart item removed successfully.');
        } else {
            return redirect('/')->with('message', 'All items have been removed from the cart.');
        }
    }

    return redirect('/cart-item')->with('error', 'Failed to remove cart item.');
}
    

// new feature
public function Profile()
{
    try {
        $user = DB::table('users')->where('id', Auth::user()->id)->first();
        return view('frontend.profile', ['user' => $user]);
    } catch (\Exception $e) {
        // Log the exact error
        \Log::error('Profile page error: ' . $e->getMessage());
        \Log::error($e->getTraceAsString());

        // Show error on screen (remove this after you find the issue)
        return response('ERROR: ' . $e->getMessage(), 500);
    }
}

public function UpdateProfile(Request $request)
{
    $request->validate([
        'name'  => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . Auth::user()->id,
    ]);

    DB::table('users')->where('id', Auth::user()->id)->update([
        'name'       => $request->name,
        'email'      => $request->email,
        'updated_at' => date('Y-m-d H:i:s'),
    ]);

    return redirect('/profile')->with('success', 'Profile updated successfully.');
}

public function ChangePassword(Request $request)
{
    $request->validate([
        'new_password' => 'required|min:8|confirmed',
    ]);

    DB::table('users')->where('id', Auth::user()->id)->update([
        'password'   => Hash::make($request->new_password),
        'updated_at' => date('Y-m-d H:i:s'),
    ]);

    return redirect('/profile')->with('success', 'Password changed successfully.');
}

public function UpdatePhoto(Request $request)
{
    $request->validate([
        'avatar' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
    ]);

    if ($request->file('avatar')) {
        $file    = $request->file('avatar');
        $profile = $this->uploadFile($file);

        DB::table('users')->where('id', Auth::user()->id)->update([
            'profile'    => $profile,
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect('/profile')->with('success', 'Profile photo updated successfully.');
    }

    return redirect('/profile')->with('error', 'No image file received.');
}

public function MyFavorites()
    {
        if (!Auth::check()) {
            return redirect('/signin');
        }

        $logo = DB::table('logo')->get();

        $favorites = DB::table('favorites')
            ->join('product', 'favorites.product_id', '=', 'product.id')
            ->where('favorites.user_id', Auth::user()->id)
            ->select('product.*', 'favorites.created_at as fav_date')
            ->orderBy('favorites.created_at', 'desc')
            ->get();

        return view('frontend.favorites', compact('logo', 'favorites'));
    }

    public function ToggleFavorite(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['status' => 'unauthenticated'], 401);
        }

        $productId = $request->product_id;
        $userId    = Auth::user()->id;

        $exists = DB::table('favorites')
            ->where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();

        if ($exists) {
            DB::table('favorites')
                ->where('user_id', $userId)
                ->where('product_id', $productId)
                ->delete();

            return response()->json(['status' => 'removed']);
        } else {
            DB::table('favorites')->insert([
                'user_id'    => $userId,
                'product_id' => $productId,
                'created_at' => now(),
            ]);

            return response()->json(['status' => 'added']);
        }
    }

    public function RemoveFavorite($productId)
    {
        if (!Auth::check()) {
            return redirect('/signin');
        }

        DB::table('favorites')
            ->where('user_id', Auth::user()->id)
            ->where('product_id', $productId)
            ->delete();

        return redirect('/my-favorites')->with('success', 'Removed from favorites.');
    }

    private function getFavIds(): array
    {
        if (!Auth::check()) return [];

        return DB::table('favorites')
            ->where('user_id', Auth::user()->id)
            ->pluck('product_id')
            ->toArray();
    }

    private function attachFav($products, array $favIds): void
    {
        foreach ($products as $p) {
            $p->is_fav = in_array($p->id, $favIds);
        }
    }

    public function logout($id)
    {
        if (Auth::check() && Auth::user()->id == $id) {
            Auth::logout();
        }
        return redirect('/');
    }
}
